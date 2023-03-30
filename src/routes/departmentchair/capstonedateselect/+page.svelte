<script lang="ts">
  const monthsInYear = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  const daysOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  const times = ["12:00","12:15","12:30","12:45","1:00","1:15","1:30","1:45","2:00","2:15","2:30","2:45","3:00","3:15","3:30","3:45","4:00","4:15","4:30","4:45","5:00","5:15","5:30","5:45","6:00"];
  
  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();  
  let daysSelected = ["March 3", "March 4", "March 5", "March 9", "March 10"];
	let numberOfDays= daysSelected.length;
	
	
	

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

<body>
  <table>
		<thead>
      <tr>
        {#each Object.values(daysSelected) as days}
					<th>{days}</th>
				{/each}
      </tr>
    </thead>
    <tbody>
       {#each Object.values(times) as row}
    <tr>
      {#each {length: numberOfDays} as i}
        <td>{row}</td>
      {/each}
    </tr>
  {/each}
    </tbody>
  </table>
</body>


<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    font-size: 1.5rem;
    height: 5rem;
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
    border-width: 1px 1px 0 1px;
    font-size: 1.5rem;
  }

  .calendar-button {
    font-size: 1.5rem;
    width: 5rem;
    height: 5rem;
  }
</style>
