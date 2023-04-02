<!-- ResponsiveTable.svelte -->
<script lang="ts">
  export let headers: string[] = [];
  export let rows: string[][] = [];
  export let columnWidth: string = 'w-96';
</script>

<div class="w-full overflow-x-auto">
  <table class="table-auto min-w-max divide-y divide-gray-200 text-center">
    <!-- Headers -->
    <thead>
      <tr>
        {#each headers as header}
          <th 
            class="border-solid border-2 border-gray-200 p-2 text-center text-2xl m-10 bg-gray-300 {columnWidth}">
            {header}
          </th>
        {/each}
      </tr>
    </thead>
    <!-- Rows -->
    <tbody class="divide-y divide-grey-200">
      {#each rows as row, rowIndex}
        <tr class="{rowIndex % 2 === 0 ? 'bg-white' : 'bg-gray-100'}">
          {#each row as cell}
            <td 
              class="border-solid border-2 border-gray-200 p-2 text-center text-xl m-10 hover:bg-gray-200 {columnWidth}">
              {cell}
            </td>
          {/each}
        </tr>
      {/each}
    </tbody>
  </table>
</div>