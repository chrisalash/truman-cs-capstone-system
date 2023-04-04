<script lang='ts'>
    import { fromJSON } from "postcss";
    import type { PageData } from './$types'
  
  export let data : PageData
  $:({ presentations }= data)
  $:({ table_size }= data)

  $: notNull = table_size as number


  let tableContainer: HTMLDivElement;
  let startY = 0;
  let startHeight = 0;
  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();
  let rows = [];
  let username = "testusernamelol"

  function getDaysInMonth(month: number, year: number) {
    return new Date(year, month + 1, 0).getDate();
  }

  function onCellButtonClick(cell: string, rowIndex: number, cellIndex: number) {
    console.log(`Clicked cell: ${cell} at row ${rowIndex}, column ${cellIndex}`);
  }

  import ResponsiveTable from '$lib/responsiveTable.svelte';

  const headers: string[] = ['Tuesday', 'Wednesday', 'Thursday', 'Friday'];
  const rows: string[][] = [
    ['3:00', '3:00', '3:00', '3;00'],
    ['4:00', '4:00', '4:00', '4:00'],
    ['5:00', '5:00', '5:00', '5:00']
  ];
  /*
  function getTimeSlots() {
    const timeSlots = [];
    let startTime = new Date();
    startTime.setHours(9, 0, 0, 0);

    for (let i = 0; i < 12; i++) {
      const timeString = startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      timeSlots.push(timeString);
      startTime.setMinutes(startTime.getMinutes() + 30);
    }

    return timeSlots;
  }
  const timeSlots = getTimeSlots();

  function getDaysArray(month: number, year: number) {
    const daysInMonth = getDaysInMonth(month, year);
    const daysArray = [];
    for (let day = 1; day <= daysInMonth; day++) {
      daysArray.push(`${month}/${day}/${year}`);
    }

    return daysArray;
  }
  const days = getDaysArray(month, year);

  function startResize(event: any) {
    startY = event.pageY;
    startHeight = tableContainer.offsetHeight;
    document.addEventListener('mousemove', resizeTable);
    document.addEventListener('mouseup', stopResize);
  }

  function resizeTable(event: any) {
    const newHeight = startHeight + (event.pageY - startY);
    tableContainer.style.height = `${newHeight}px`;
  }

  function stopResize() {
    document.removeEventListener('mousemove', resizeTable);
    document.removeEventListener('mouseup', stopResize);
  }
  */
</script>

<main class='flex flex-col'>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Student Tools</h1>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <div class='mb-4'>
      <h3 class='text-3xl'>Spring - {year}</h3>
    </div>
    <ResponsiveTable {headers} {rows} columnWidth="w-[50.4rem]" {onCellButtonClick} />
    <!--
    <div class="table-container" bind:this={tableContainer}>
      <table class='border-collapse w-full'>
        <thead>
          <tr>
            {#each presentations as presentation}
              <th class='border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300'>{presentation.date}</th>
            {/each}
          </tr>
        </thead>
        <tbody>
          {#each {length: notNull} as count, i}
            <tr>
              {#each presentations as presentation}
                {#if presentation.time_start[i] != undefined}
                  {#if presentation.slot_taken[i] == 1}
                    <td class='border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer text-center text-xl m-10' id={presentation.id[i]}>{presentation.time_start[i]}-{presentation.time_end[i]}</td>
                  {:else}
                    <td class='border-solid border-2 border-gray-200 p-2 text-center text-gray-500 text-xl m-10'>{presentation.time_start[i]}-{presentation.time_end[i]}</td>
                  {/if}
                {:else}
                  <td></td>
                {/if}
              {/each}
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
    -->
    <!--
    <div class='vertical-resizer' on:mousedown={startResize}>
      <span style='width: 15px; height: 1px; background-color: #fff;' />
    </div>
    -->
  </div>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>Another cell if need be.</div>
</main>

