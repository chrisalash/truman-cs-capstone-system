<script lang='ts'>
  const monthsInYear = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];
  const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

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

<main class='flex flex-col'>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Department Chair Tools</h1>
  </div>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <div class='w-full bg-white'>
      <div class='flex justify-between items-center p-1 border-solid border-2 border-gray-200 text-4xl rounded'>
        <button class='transition-all duration-200 w-20 h-20 text=4xl rounded bg-gray-300 hover:bg-gray-400' on:click={previousMonth}>&lt;</button>
        <h3>{year} - {monthsInYear[month]}</h3>
        <button class='transition-all duration-200 w-20 h-20 text=4xl rounded bg-gray-300 hover:bg-gray-400' on:click={nextMonth}>&gt;</button>
      </div>
      <table class='border-collapse w-full'>
        <thead>
          <tr>
            {#each daysOfWeek as day}
              <th class='border-solid border-2 border-gray-200 p-2 text-center text-4xl m-10 bg-gray-300'>{day}</th>
            {/each}
          </tr>
        </thead>
        <tbody>
          {#each Array(getWeeks(month, year)) as _, i}
            <tr>
              {#each Array(7).fill(0) as _, j}
                {#if i === 0 && j < getFirstDayOfWeek(month, year)}
                  <td class='border-solid border-2 border-gray-200 p-2 text-center text-4xl m-10'/>
                {:else if i === getWeeks(month, year) - 1 && j > getLastDayOfWeek(month, year)}
                  <td class='border-solid border-2 border-gray-200 p-2 text-center text-4xl m-10'/>
                {:else}
                  <td class='transition-all duration-200 cursor-pointer border-solid border-2 border-gray-200 p-8 text-center text-4xl hover:bg-gray-300'>{getDayOfMonth(i * 7 + j, month, year)}</td>
                {/if}
              {/each}
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </div>
  <div class='flex ml-4 w-full bg-white rounded p-4'>
    Another cell if need be
  </div>
</main>
