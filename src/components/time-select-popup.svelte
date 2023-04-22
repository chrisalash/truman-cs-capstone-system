<script lang="ts">
    export let message: string;
    export let confirmButtonText: string;
    export let cancelButtonText: string;
    export let showContent = true;
    export let date: String;
    export let selectedDates: String[];
    export let selectedStartTimes: String[];
    export let selectedEndTimes: String[];

    function toggle() {
    showContent = !showContent;
    }

    const intervals: number[] = [10, 15, 30, 60]

    let start_time: String = ''
    let end_time: String = ''
    let interval: number = 15


    function interval_add() {
        const [hours, minutes] = start_time.split(":");
        let editedHours = Number(hours);
        let editedMinutes = Number(minutes);

        const [end_hours, end_minutes] = end_time.split(":");
        let endHours = Number(end_hours);
        let endMinutes = Number(end_minutes);

        while(editedHours < endHours || !(editedHours == endHours && editedMinutes + interval >= endMinutes)) {
        // Make sure the hours and minutes are within valid ranges
            let start = `${editedHours.toString().padStart(2, "0")}:${editedMinutes.toString().padStart(2, "0")}`
            editedMinutes = editedMinutes + interval
            if (editedHours < 0) {
                editedHours += 24;
            } else if (editedHours >= 24) {
                editedHours -= 24;
            }
            if (editedMinutes < 0) {
                editedMinutes += 60;
                editedHours--;
            } else if (editedMinutes >= 60) {
                editedMinutes -= 60;
                editedHours++;
            }
            let end = `${editedHours.toString().padStart(2, "0")}:${editedMinutes.toString().padStart(2, "0")}`
            selectedDates.push(date)
            selectedStartTimes.push(start)
            selectedEndTimes.push(end)
        }
        selectedDates = selectedDates
        selectedStartTimes = selectedStartTimes
        selectedEndTimes = selectedEndTimes
        toggle()
    }
</script>

{#if showContent}
    <div class="z-50 p-5 flex flex-col justify-center items-center fixed top-0 left-0 w-screen h-screen bg-black/80">
    <div class="p-5 flex flex-col justify-center rounded-lg bg-white">
        <div class="flex flex-col justify-center items-center">
        <p class="text-2xl">{message}</p>
        <div class="flex flex-row mt-4 ">
            <div class="flex flex-col">
                <h1 class="text-xl">Start Time</h1>
                <input class="border-solid border border-gray-200 cursor-pointer h-10 w-40 text-2xl hover:bg-gray-300" type=time bind:value={start_time}>
            </div>
            <div class="flex flex-col">
                <h1 class="text-xl">End Time</h1>
                <input class="border-solid border border-gray-200 cursor-pointer h-10 w-40 text-2xl hover:bg-gray-300" type=time bind:value={end_time}>
            </div>
            <div class="flex flex-col">
                <h1 class="text-xl">Interval</h1>
                <select class="transition-all duration-200 border-solid border border-gray-200 cursor-pointer h-10 w-40 text-2xl hover:bg-gray-300" bind:value={interval}>
                    {#each intervals as interval}
                        <option>{interval} Minutes</option>
                    {/each}
                </select>
            </div>
        </div>
        <div class="flex flex-row">
            <button on:click={() => interval_add()} class="transition-all duration-200 mt-5 p-3 rounded bg-gray-200 text-xl hover:bg-gray-300">{confirmButtonText}</button>
            <button on:click={() => toggle()} class="transition-all duration-200 mt-5 ml-5 p-3 rounded bg-violet-200 text-xl hover:bg-violet-300">{cancelButtonText}</button>
        </div>
        </div>
    </div>
    </div>
{/if}