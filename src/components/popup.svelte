<script lang="ts">
  export let message: string;
  export let confirmButtonText: string;
  export let cancelButtonText: string;
  export let confirmFunction = () => {};

  let confirmFunctionParent = confirmFunction();
  let showContent = true;

  function toggle() {
    showContent = !showContent;
  }
</script>

{#if showContent}
  <div class="z-50 p-5 flex flex-col justify-center items-center fixed top-0 left-0 w-screen h-screen bg-black/80">
    <div class="p-5 flex flex-col justify-center rounded-lg bg-white">
      <div class="flex flex-col justify-center items-center">
        <p class="text-2xl">{message}</p>
        <div class="flex-row">
          <button on:click={confirmFunctionParent} class="mt-5 p-3 rounded bg-gray-400 text-xl hover:bg-gray-300">{confirmButtonText}</button>
          <button on:click={() => toggle()} class="mt-5 ml-5 p-3 rounded bg-gray-400 text-xl hover:bg-gray-300">{cancelButtonText}</button>
        </div>
      </div>
    </div>
  </div>
{/if}
