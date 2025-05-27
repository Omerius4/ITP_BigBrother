let workTime = 25 * 60;
let breakTime = 5 * 60;
let seconds = workTime;
let interval = null;
let sessionCount = 0;
let isWork = true;

function updateDisplay() {
  const min = Math.floor(seconds / 60);
  const sec = seconds % 60;
  document.getElementById("timer").textContent = `${min}:${sec < 10 ? '0' : ''}${sec}`;
  document.getElementById("status").textContent = isWork ? "Work Session" : "Break Time";
  document.getElementById("cycle").textContent = `Cycle: ${sessionCount} / 4`;
}

function startPomodoro() {
  document.getElementById("startBtn").disabled = true;
  if (interval) return;

  interval = setInterval(() => {
    seconds--;
    updateDisplay();

    if (seconds <= 0) {
      clearInterval(interval);
      interval = null;

      if (isWork) {
        sessionCount++;
        alert("Work session done! Time for a break.");
        fetch('/api/study.php', { method: 'POST' });
      } else {
        alert("Break finished! Back to work.");
      }

      if (sessionCount >= 4 && isWork) {
        alert("🎉 You've completed 4 Pomodoros! Great job!");
        sessionCount = 0;
      }

      isWork = !isWork;
      seconds = isWork ? workTime : breakTime;
      updateDisplay();
      startPomodoro(); // continue automatically
    }
  }, 1000);
}

updateDisplay();
