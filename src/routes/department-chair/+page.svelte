<script lang='ts'>
    import { text } from "svelte/internal";
    import Popup from "../../components/popup.svelte";
    import TimeSelectPopup from "../../components/time-select-popup.svelte";

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
  const headers = ['Date', 'Time Start', 'Time End', '']

  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();
  
  let popup_visibility = false
  // values for the time select popup
  let selectedDate: String
  let timeSelectVisibility = false

  export let selectedDates: String[] = [];
  export let selectedStartTimes: String[] = [];
  export let selectedEndTimes: String[] = [];

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

  function addDate(number: String | null) {
    if(number != null) {
        let this_month = month + 1
        selectedDate = year + "-" + this_month + "-" + getDayOfMonth(+number, month, year)
        timeSelectVisibility = true
    }
  }

  function deleteDate(id: String | null){
    if(id != null) {
      selectedDates.splice(+id,1)
      selectedStartTimes.splice(+id,1)
      selectedEndTimes.splice(+id,1)
      selectedDates = selectedDates
      selectedStartTimes = selectedStartTimes
      selectedEndTimes = selectedEndTimes
    }
  }

  function toggle_popup_visibility(){
    popup_visibility=!popup_visibility
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
          <TimeSelectPopup message="Are you sure you would like to submit these times?" confirmButtonText="confirm" cancelButtonText="cancel" bind:selectedDates={selectedDates} bind:selectedStartTimes={selectedStartTimes} bind:selectedEndTimes= {selectedEndTimes} bind:showContent={timeSelectVisibility} bind:date={selectedDate}></TimeSelectPopup>
          {#each Array(getWeeks(month, year)) as _, i}
            <tr>
              {#each Array(7).fill(0) as _, j}
                {#if i === 0 && j < getFirstDayOfWeek(month, year)}
                  <td class='border-solid border-2 border-gray-200 p-2 text-center text-4xl m-10'/>
                {:else if i === getWeeks(month, year) - 1 && j > getLastDayOfWeek(month, year)}
                  <td class='border-solid border-2 border-gray-200 p-2 text-center text-4xl m-10'/>
                {:else}
                <td class='transition-all duration-200 border-solid border-2 border-gray-200 p-8 text-center text-4xl hover:bg-gray-300'>
                  <button value={i * 7 + j} class="cursor-pointer" style="width: 100%; height: 100%" on:click={(event)=>addDate(event.currentTarget.getAttribute("value"))}>
                    {getDayOfMonth(i * 7 + j, month, year)}
                  </button>
                </td>
                {/if}
              {/each}
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
  </div>
  <div class='flex ml-4 w-full bg-white rounded p-4'>
    <table class='border-collapse w-full'>
      <thead>
        <tr>
          {#each headers as header}
            <th class='border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300'>{header}</th>
          {/each}
        </tr>
      </thead>
      <tbody>
        {#if selectedDates != undefined}
          {#each selectedDates as date, i}
            <tr>
                <td class='border-solid border-2 border-gray-200 p-2 text-center text-xl m-10'>{date}</td>
                <td class='border-solid border-2 border-gray-200 p-2 text-center text-xl m-10'>
                  <input class="border-solid border border-gray-200 cursor-pointer h-10 w-40 text-2xl hover:bg-gray-300" type=time bind:value={selectedStartTimes[i]}>
                </td>
                <td class='border-solid border-2 border-gray-200 p-2 text-center text-xl m-10'>
                  <input class="border-solid border border-gray-200 cursor-pointer h-10 w-40 text-2xl hover:bg-gray-300" type=time bind:value={selectedEndTimes[i]}>
                </td>
                <td class='border-solid border-2 border-gray-200 p-2 cursor-pointer text-center text-xl m-10'>
                  <button name={i.toString()} class="bg-red-400 h-12 w-24 text-white" on:click={(event)=>deleteDate(event.currentTarget.getAttribute("name"))}>
                    Delete
                  </button>
                </td>
            </tr>
          {/each}
        {/if}
      </tbody>
    </table>
  </div>
  <div class='flex ml-4 w-full bg-white rounded p-4'>
    <button class="border-solid border-2 border-lime-500 bg-lime-400 font-extrabold h-12 rounded-full w-24 text-white" on:click={toggle_popup_visibility}> Confirm</button>
      <Popup message="Are you sure you would like to submit these times?" formAction="?/Set_Dates" confirmButtonText="confirm" cancelButtonText="cancel" contents_value ={[selectedDates, selectedStartTimes, selectedEndTimes]} contents_names={["date","time_start","time_end"]} bind:showContent={popup_visibility}> </Popup>
  </div>
</main>
