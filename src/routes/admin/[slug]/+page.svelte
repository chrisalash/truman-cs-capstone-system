<script lang="ts">
  import { goto } from '$app/navigation';
  import Popup from '../../../components/popup.svelte';

  type datatype = {
    data_info: Record<string, any>[];
    columns: string[];
  };

  export let data: datatype;
  $: ({ data_info } = data);
  $: ({ columns } = data);

  if (data_info == null || columns == null) {
    data_info = [];
    columns = [];
  }

  let tableinfoStrings: String = '';
  let popup_visibility = false;

  const databases = ['none', 'capstone_presentations', 'capstone_presentations_archive'];

  function stringify(i: string | null) {
    console.log(data_info);
    console.log(columns);
    if (i != null) {
      tableinfoStrings = JSON.stringify(data_info[+i], (_, v) =>
        typeof v === 'bigint' ? v.toString() : v
      );
    }
  }

  function update_date(date: string | null, i: number, key: string) {
    if (date != null) data_info[i][key] = date;
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
    let selectedRoute = (event.target as HTMLSelectElement).value;
    if ((event.target as HTMLSelectElement).value.trim() == 'none') {
      selectedRoute = window.location.origin + '/admin';
    }
    goto(selectedRoute);
  }

  function toggle_popup_visibility() {
    popup_visibility = !popup_visibility;
  }
</script>

<main class="flex flex-col">
  <div class="flex ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-5xl text-violet-800">Admin Tools</h1>
  </div>
  <div class="flex flex-col ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-3xl text-violet-800 mb-2">Warning</h1>
    <p class="text-xl">
      This is the administrative access point. If you are not an authorized administrator, please
      leave now.
    </p>
  </div>
  <div class="flex flex-col ml-4 mb-8 w-full bg-white rounded p-4">
    <h1 class="text-3xl text-violet-800 mb-2">Database Access</h1>
    <div class="mt-4 flex flex-col items-center space-x-2">
      <h1 class="text-3xl text-violet-800 mb-2">Select an option:</h1>
      <select
        on:change={route_to_database}
        class="block appearance-none w-full mb-2 bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded cursor-pointer shadow leading-tight focus:outline-none focus:shadow-outline-blue w-56"
      >
        {#each databases as database}
          <option>
            {database}
          </option>
        {/each}
      </select>
    </div>
    <div style="overflow: auto;">
      {#if data_info != null && columns != null && data_info.length}
        <table class="border-collapse w-full">
          <thead>
            <tr>
              {#each columns as column}
                <th
                  class="border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300"
                  >{column}</th
                >
              {/each}
              <th
                class="border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300"
                >Save</th
              >
              <th
                class="border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300"
                >Delete</th
              >
            </tr>
          </thead>
          <tbody>
            {#each data_info as student, i}
              <tr>
                {#each Object.keys(student) as keys}
                  <td
                    class="border-solid border-2 border-gray-200 p-2 cursor-pointer text-gray-500 text-center text-m m-10"
                  >
                    {#if typeof student[keys] === 'string' && isValidDateTimeLocal(student[keys])}
                      <input
                        type="datetime-local"
                        class="hover:bg-gray-300 w-full"
                        value={student[keys]}
                        on:change={(event) =>
                          update_date(event.currentTarget.getAttribute('value'), i, keys)}
                      />
                    {:else}
                      <input class="hover:bg-gray-300 h-full w-full" bind:value={student[keys]} />
                    {/if}
                  </td>
                {/each}
                <td
                  class="border-solid border-2 border-gray-200 p-2 cursor-pointer text-center text-m m-10"
                >
                  <form action="?/Save_Row" method="POST">
                    <button
                      class="transition-all duration-200 p-3 rounded bg-gray-200 text-xl hover:bg-gray-300"
                      name={i.toString()}
                      on:click={(event) => stringify(event.currentTarget.getAttribute('name'))}
                    >
                      Save
                    </button>
                    <input type="hidden" name="object" bind:value={tableinfoStrings} />
                  </form>
                </td>
                <td
                  class="border-solid border-2 border-gray-200 p-2 cursor-pointer text-center text-m m-10"
                >
                  <form action="?/Remove_Row" method="POST">
                    <button
                      class="transition-all duration-200 p-3 rounded bg-violet-200 text-xl hover:bg-violet-300"
                    >
                      Delete
                    </button>
                    <input type="hidden" name="id" value={student['id']} />
                  </form>
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      {/if}
    </div>
  </div>
  <div class="flex flex-col ml-4 w-full bg-white rounded p-4">
    <h1 class="text-3xl mb-4 text-violet-800">Archiving</h1>
    <Popup
      message="Would you like to archive the current capstone presentations?"
      formAction="?/Archive_Presentations"
      bind:showContent={popup_visibility}
    />
    <button
      class="transition-all duration-200 p-3 rounded bg-violet-200 text-xl hover:bg-violet-300"
      on:click={toggle_popup_visibility}
    >
      Archive Presentations</button
    >
  </div>
</main>
