
const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");
const UPDATE_SCORE_URL = "../../php/updateScore.php";


const player = {
  x: canvas.width / 2 - 25,
  y: canvas.height - 70,
  width: 50,
  height: 40,
  speed: 6,
  color: "lime"
};

let bullets = [];
let enemies = [];
let keys = {};
let score = 0;
let lives = 3;
let gameOver = false;
let scoreSaved = false;

const saveStatusEl = document.getElementById("saveStatus");

const enemyTypes = [
  {
    name: "",
    width: 40,
    height: 40,
    speed: 2,
    color: "red",
    points: 1,
    health: 2
  },
  {
    name: "",
    width: 30,
    height: 30,
    speed: 4,
    color: "orange",
    points: 2,
    health: 1
  },
  {
    name: "",
    width: 60,
    height: 50,
    speed: 1,
    color: "purple",
    points: 5,
    health: 5
  }
];

document.addEventListener("keydown", function (e) {
  keys[e.code] = true;

  if (e.code === "Space") {
    shoot();
  }

  if (gameOver && e.code === "Enter") {
    restartGame();
  }
});

document.addEventListener("keyup", function (e) {
  keys[e.code] = false;
});

function shoot() {
  if (gameOver) return;

  bullets.push({
    x: player.x + player.width / 2 - 4,
    y: player.y,
    width: 8,
    height: 15,
    speed: 7,
    color: "yellow"
  });
}

function spawnEnemy() {
  if (gameOver) return;

  const type = enemyTypes[Math.floor(Math.random() * enemyTypes.length)];

  enemies.push({
    x: Math.random() * (canvas.width - type.width),
    y: -type.height,
    width: type.width,
    height: type.height,
    speed: type.speed,
    color: type.color,
    points: type.points,
    name: type.name,
    health: type.health,
    maxHealth: type.health
  });
}

setInterval(spawnEnemy, 900);

function update() {
  if (gameOver) return;
  // regolo velocita nemici 
  if (keys["ArrowLeft"] && player.x > 0) {
    player.x -= player.speed;
  }

  if (keys["ArrowRight"] && player.x + player.width < canvas.width) {
    player.x += player.speed;
  }
// salita dei proiettili
  for (let i = bullets.length - 1; i >= 0; i--) {
    bullets[i].y -= bullets[i].speed;

    if (bullets[i].y + bullets[i].height < 0) {
      bullets.splice(i, 1);
    }
  }
// se esce dal basso -1
  for (let i = enemies.length - 1; i >= 0; i--) {
    enemies[i].y += enemies[i].speed;

    if (enemies[i].y > canvas.height) {
      enemies.splice(i, 1);
      lives--;

      if (lives <= 0) {
        terminaPartita();
      }
    }
  }

  checkCollisions();
}

function checkCollisions() {
  for (let i = enemies.length - 1; i >= 0; i--) {
    const enemy = enemies[i];

    // Collisione proiettili contro nemici
    for (let j = bullets.length - 1; j >= 0; j--) {
      const bullet = bullets[j];

      if (
        bullet.x < enemy.x + enemy.width &&
        bullet.x + bullet.width > enemy.x &&
        bullet.y < enemy.y + enemy.height &&
        bullet.y + bullet.height > enemy.y
      ) {
        // Il proiettile colpisce il nemico
        enemy.health--;

        // Il proiettile sparisce sempre dopo il colpo
        bullets.splice(j, 1);

        // Se la vita arriva a 0, il nemico viene distrutto
        if (enemy.health <= 0) {
          score += enemy.points;
          enemies.splice(i, 1);
        }

        // Esco dal ciclo dei proiettili per evitare problemi
        break;
      }
    }

    // Se il nemico è stato eliminato, salto la collisione col player
    if (!enemies[i]) continue;

    const currentEnemy = enemies[i];

    // Collisione nemico contro giocatore
    if (
      player.x < currentEnemy.x + currentEnemy.width &&
      player.x + player.width > currentEnemy.x &&
      player.y < currentEnemy.y + currentEnemy.height &&
      player.y + player.height > currentEnemy.y
    ) {
      enemies.splice(i, 1);
      lives--;

      if (lives <= 0) {
        terminaPartita();
      }
    }
  }
}

function drawPlayer() {
  ctx.fillStyle = player.color;
  ctx.fillRect(player.x, player.y, player.width, player.height);

  ctx.fillStyle = "white";
  ctx.fillRect(player.x + 20, player.y - 15, 10, 15);
}

function drawBullets() {
  bullets.forEach(bullet => {
    ctx.fillStyle = bullet.color;
    ctx.fillRect(bullet.x, bullet.y, bullet.width, bullet.height);
  });
}

function drawEnemies() {
  enemies.forEach(enemy => {
    ctx.fillStyle = enemy.color;
    ctx.fillRect(enemy.x, enemy.y, enemy.width, enemy.height);

    ctx.fillStyle = "white";
    ctx.font = "12px Arial";
    ctx.fillText(enemy.name, enemy.x + 3, enemy.y + enemy.height / 2);
  });
}

function drawHUD() {
  ctx.fillStyle = "white";
  ctx.font = "20px Arial";
  ctx.fillText("Punteggio: " + score, 20, 30);
  ctx.fillText("Vite: " + lives, 500, 30);
}


function terminaPartita() {
  if (gameOver) return;
  gameOver = true;
  salvaPunteggioSuDB(score);
}
// Funzione per salvare il punteggio sul database
// mando un json (non molto sicuro)
async function salvaPunteggioSuDB(punti) {
  // Evita di salvare più volte la stessa partita
  if (scoreSaved) return;
  scoreSaved = true;
 
  if (punti <= 0) {
    if (saveStatusEl) saveStatusEl.textContent = "nessun punto da salvare";
    return;
  }

  try {
    const resp = await fetch(UPDATE_SCORE_URL, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ delta: punti })
    });

    const data = await resp.json().catch(() => null);

    if (!resp.ok || !data || data.ok !== true) {
      console.warn("Errore updateScore:", resp.status, data);
      if (saveStatusEl) saveStatusEl.textContent = "errore salvataggio";
      return;
    }

    const dbWinsEl = document.getElementById("dbWins");
    if (dbWinsEl && typeof data.punteggio !== "undefined") {
      dbWinsEl.textContent = data.punteggio;
    }

    if (saveStatusEl) saveStatusEl.textContent = "salvato";
  } catch (e) {
    console.error("Fetch updateScore fallita:", e);
    if (saveStatusEl) saveStatusEl.textContent = "errore rete";
  }
}
// mostro punteggio finlle scrive game over
function drawGameOver() {
  ctx.fillStyle = "rgba(0, 0, 0, 0.7)";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  ctx.fillStyle = "white";
  ctx.font = "45px Arial";
  ctx.fillText("GAME OVER", 165, 330);

  ctx.font = "22px Arial";
  ctx.fillText("Punteggio finale: " + score, 210, 380);
  ctx.fillText("Premi ENTER per ricominciare", 165, 430);
}
// pulizia canvas
function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  drawPlayer();
  drawBullets();
  drawEnemies();
  drawHUD();

  if (gameOver) {
    drawGameOver();
  }
}
// richiama se stesso al frame successivo
function gameLoop() {
  update();
  draw();
  requestAnimationFrame(gameLoop);
}

function restartGame() {
  player.x = canvas.width / 2 - 25;
  bullets = [];
  enemies = [];
  score = 0;
  lives = 3;
  gameOver = false;
  scoreSaved = false;
  if (saveStatusEl) saveStatusEl.textContent = "pronto";
}
//avvia tutto 
gameLoop();