<script lang="ts">
  let tableContainer: HTMLDivElement;
  let startY = 0;
  let startHeight = 0;
  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth();  
  let rows = [];
  
  function getDaysInMonth(month: number, year: number) {
    return new Date(year, month + 1, 0).getDate();
  }

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
</script>


<h1>CS Students - Capstone Presentation Date Selections</h1>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Capstone Date Selection</title>
</head>
<body>
  <nav id="sidebar">
    <ul>
      <li><a href="dummy.html">Student</a></li>
      <li><a href="../">Home</a></li>
      <li><a href="dummy.html">Date Select</a></li>
    </ul>
  </nav>
  <main>
    <div class="header">
      <h3>Spring - {year}</h3>
    </div>
    <div class="table-container" bind:this={tableContainer}>
      <table>
        <thead>
          <tr>
            {#each days as day}
            <th class="cell-width">{day}</th>
            {/each}
          </tr>
        </thead>
        <tbody>
          {#each timeSlots as timeSlot}
            <tr>
              {#each days as day}
                <td class="cell-width">{timeSlot}</td>
              {/each}
            </tr>
          {/each}
        </tbody>
      </table>
    </div>
    <div class="vertical-resizer" on:mousedown={startResize}>
      <span style="width: 15px; height: 1px; background-color: #fff;"></span>
    </div>
  </main>
</body>



<style>
h1 {
  background-color: purple;
  color: #fff;
  margin: 000;
  padding: 100;
  height: 70px;
}

#sidebar {
  background-color: #333;
  width: 150px;
  height: 100vh;
  position: fixed;
  padding: 20px;
}
#sidebar ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
#sidebar li {
  margin-bottom: 20px;
}
#sidebar a {
  text-decoration: none;
  color: #fff;
}
#sidebar a:hover {
  color: #ccc;
}

main {
  margin-left: 190px;
  padding: 20px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  border: 1px solid #ccc;
  border-width: 1px 1px 0 1px
}
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}
.table-container {
  overflow-x: auto;
  white-space: nowrap;
  width: 100%;
  position: relative;
}
table {
  border-collapse: collapse;
  width: 9000px;
}
th, td {
  border: 1px solid #ccc;
  padding: 8px;
  text-align: center;
}
th {
  background-color: #f2f2f2;
  font-weight: bold;
  width: 500px;
}
tbody {
  height: auto;
}
.cell-width {
    width: 500px;
}

.vertical-resizer {
  width: 100%;
  height: 5px;
  background-color: #ccc;
  cursor: row-resize;
  user-select: none;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
