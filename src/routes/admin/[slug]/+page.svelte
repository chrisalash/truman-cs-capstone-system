<script lang='ts'>
import { goto } from '$app/navigation';

type datatype = {
  data_info: Record<string, any>[],
  columns: String[]
}

export let data : datatype
  $:({ data_info }= data)
  $:({ columns }= data)
  
  let tableinfoStrings: String = ''
  let changed_date_id: Record<string, any>[]

  const databases = ["student", "capstone_presentations"]

  function stringify(i: string | null) {
    console.log(data_info)
    console.log(columns)
    if(i != null){
      tableinfoStrings = JSON.stringify(data_info[+i], (_, v) => typeof v === 'bigint' ? v.toString() : v)
    }
  }

  function update_date(date: string | null, i: number, key: string) {
    if(date != null)
      data_info[i][key] = date
  }

  function isValidDateTimeLocal(dateTimeString: string): boolean {
    const regex = /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})$/;
    const match = dateTimeString.match(regex);
    if (!match) {
      return false;
    }
    const year = parseInt(match[1]);
    const month = parseInt(match[2]);
    const day = parseInt(match[3]);
    const hour = parseInt(match[4]);
    const minute = parseInt(match[5]);
    const date = new Date(year, month - 1, day, hour, minute);
    return (
      date.getFullYear() === year &&
      date.getMonth() === month - 1 &&
      date.getDate() === day &&
      date.getHours() === hour &&
      date.getMinutes() === minute
    );
  }

  function route_to_database(event: Event) {
    const selectedRoute = (event.target as HTMLSelectElement).value;
    goto(selectedRoute);
  }

</script>

<main class='flex flex-col'>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Admin Tools</h1>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-2xl text-violet-800'>Warning</h1>
    This is the administrative access point. If you are not an authorized administrator, please leave now.
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-2xl text-violet-800'>Database Access</h1>
    <div class="mt-4 flex items-center space-x-2">
      <label for="select" class="text-gray-700 font-medium">Select an option:</label>
    <select on:change={route_to_database} class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline-blue w-56">
      {#each databases as databas}
      <option>
        {databas}
      </option>
      {/each}
    </select>
  </div>
      <div style="overflow: auto;">
        {#if data_info != null && columns != null}
        <table class='border-collapse w-full'>
          <thead>
            <tr>
            {#each columns as column}
              <th class='border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300'>{column}</th>
            {/each}
            <th class='border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300'>Delete</th>
            <th class='border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300'>Save</th>
            </tr>
          </thead>
          <tbody>
            {#each data_info as student, i}
            <tr>
              {#each Object.keys(student) as keys}
              <td class='border-solid border-2 border-gray-200 p-2 cursor-pointer text-gray-500 text-center text-m m-10'>
                {#if typeof student[keys] === 'string' && isValidDateTimeLocal(student[keys]) }
                  <input type="datetime-local" class="hover:bg-gray-300 w-full" value = {student[keys]} on:change = {(event)=>update_date(event.currentTarget.getAttribute("value"),i,keys)}>
                {:else}
                  <input class="hover:bg-gray-300 h-full w-full" bind:value={student[keys]}>
                {/if}
              </td>
              {/each}
              <td class='border-solid border-2 border-gray-200 p-2 cursor-pointer text-gray-500 text-center text-m m-10'>
                <form action="?/Remove_Row" method="POST">
                  <button class="bg-red-400 hover:bg-red-500 text-white font-bold py-2 px-4 rounded">
                    Delete
                  </button>
                  <input type="hidden" name="id" value={student["id"]} />
                </form>
              </td>
              <td class='border-solid border-2 border-gray-200 p-2 cursor-pointer text-gray-500 text-center text-m m-10'>
                <form action="?/Save_Row" method="POST">
                  <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" name={i.toString()} on:click={(event)=>stringify(event.currentTarget.getAttribute("name"))}>
                    Save
                  </button>
                  <input type="hidden" name="object" bind:value={tableinfoStrings} />
                </form>
              </td>
            </tr>
            {/each}
          </tbody>
        </table>
        {/if}
    </div>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-2xl text-violet-800'>View Logs</h1>
    Some text.
  </div>
</main>
