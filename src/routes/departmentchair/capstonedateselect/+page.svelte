<script lang="ts">
  const monthsInYear = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();  

  function getDaysInMonth(month: number, year: number) {
    return new Date(year, month + 1, 0).getDate();
  }
  
  function getFirstDayOfWeek(month: number, year: number) {
    return new Date(year, month, 1).getDay();
  }

  function getDayOfMonth(day: number, month: number, year: number) {
    const date = day - getFirstDayOfWeek(month, year) + 1;

    return date > 0 && date <= getDaysInMonth(month, year) ? date : null;
  }

  function getLastDayOfWeek(month: number, year: number) {
    return new Date(year, month, getDaysInMonth(month, year)).getDay();
  }

  function getWeeks(month: number, year: number) {
    return Math.ceil((getDaysInMonth(month, year) + getFirstDayOfWeek(month, year)) / 7);
  }

  function previousMonth() {
    if (month === 0) {
      month = 11;
      year -= 1;
    } else {
      month -= 1;
    }
  }
  
  function nextMonth() {
    if (month === 11) {
      month = 0;
      year += 1;
    } else {
      month += 1;
    }
  }
</script>

<h1>CS Department Chair - Capstone Presentation Date Selections</h1>
<div class="calendar">
  <div class="header">
    <button class="calendar-button" on:click={previousMonth}>&lt;</button>
    <h3>{year} - {monthsInYear[month]}</h3>
    <button class="calendar-button" on:click={nextMonth}>&gt;</button>
  </div>
  <table>
    <thead>
      <tr>
        {#each daysOfWeek as day}
          <th>{day}</th>
        {/each}
      </tr>
    </thead>
    <tbody>
      {#each Array(getWeeks(month, year)) as _, i}
        <tr>
          {#each Array(7).fill(0) as _, j}
            {#if i === 0 && j < getFirstDayOfWeek(month, year)}
              <td></td>
            {:else if i === getWeeks(month, year) - 1 && j > getLastDayOfWeek(month, year)}
              <td></td>
            {:else}
              <td>{getDayOfMonth(i * 7 + j, month, year)}</td>
            {/if}
          {/each}
        </tr>
      {/each}
    </tbody>
  </table>
</div>


<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
  }

  th {
    background-color: #eee;
  }

  td {
    cursor: pointer;
  }

  td:hover {
    background-color: #f0f0f0;
  }

  .calendar {
    width: 100%;
  }
  
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border: 1px solid #ccc;
    border-width: 1px 1px 0 1px
  }

  .calendar-button {
    width: 50px;
    height: 50px;
  }
</style>
