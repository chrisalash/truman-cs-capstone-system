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
  let username = "testuserna"

</script>

<main class='flex flex-col'>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>
    <h1 class='text-5xl text-violet-800'>Student Tools</h1>
  </div>
  <div class='flex flex-col ml-4 mb-8 w-full bg-white rounded p-4'>
    <div class='mb-4'>
      <h3 class='text-3xl'>Spring - {year}</h3>
    </div>
    <div bind:this={tableContainer}>
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
                  <td style='height: 100%' class='border-solid border-2 border-gray-200 hover:bg-gray-300 p-2 cursor-pointer text-gray-500 text-center text-xl m-10'>
                    <form action="?/Student_Change_Time" method="POST">
                      <button style="width: 100%; height: 100%">
                        {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                        <span class='text-gray-400'>No Student</span>
                      </button>
                      <input type="hidden" name="presentation_id" value={presentation.id[i]} />
                      <input type="hidden" name="username" value={username} />
                    </form>
                  </td>
                  {:else}
                    <td class='border-solid border-2 border-gray-200 p-2 text-center text-xl m-10'>
                      {presentation.time_start[i]}-{presentation.time_end[i]}<br>
                      <span class='text-gray-600'>{presentation.username[i]}</span>
                    </td>
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
  </div>
  <div class='flex ml-4 mb-8 w-full bg-white rounded p-4'>Another cell if need be.</div>
</main>
