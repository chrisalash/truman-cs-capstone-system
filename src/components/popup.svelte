<script lang="ts">
  export let message: string;
  export let confirmButtonText: string = 'Yes';
  export let cancelButtonText: string = 'Cancel';
  export let formAction: string;
  export let contents_value: (String[] | Date[])[] = [];
  export let contents_names: string[] = [];
  export let showContent = false;

  function toggle() {
    showContent = !showContent;
  }
</script>

{#if showContent}
  <div
    class="z-50 p-5 flex flex-col justify-center items-center fixed top-0 left-0 w-screen h-screen bg-black/80"
  >
    <div class="p-5 flex flex-col justify-center rounded-lg bg-white">
      <div class="flex flex-col justify-center items-center">
        <p class="text-2xl">{message}</p>
        <div class="flex-row">
          <form action={formAction} method="POST">
            <button
              type="submit"
              class="transition-all duration-200 mt-5 p-3 rounded bg-gray-200 text-xl hover:bg-gray-300"
              >{confirmButtonText}</button
            >
            <button
              on:click={() => toggle()}
              class="transition-all duration-200 mt-5 ml-5 p-3 rounded bg-violet-200 text-xl hover:bg-violet-300"
              >{cancelButtonText}</button
            >
            {#each contents_names as name, i}
              <input type="hidden" {name} value={contents_value[i]} />
            {/each}
          </form>
        </div>
      </div>
    </div>
  </div>
{/if}
