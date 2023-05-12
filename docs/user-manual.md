# User Manual for CS Capstone Presentation Website

## Basics

### About
This website is for the scheduling of Truman Computer Science capstone presentations.

### How to Use
Navigate to this site from the CS capstone system. The first page is the `Home Page`, with general information. This page corresponds to the `Home` tab on the left. The current username is also displayed on the left, and depending on the user there will be different pages available.

To return to the main CS capstone site, select `Capstone System` on the left.

## Student Page

### Info
This page is intended for Computer Science students that are presenting their capstone. It allows for the student to schedule their capstone presentation, check the time they have scheduled for, and change when they are presenting.

### How to Use
Navigate to the `Student` tab by selecting it on the left. There will be a grid with all possible presentation times (as selected by the department chair). Times that other students have selected are unavailable, and show as greyed-out entries on the grid. Available times will show up in black.

### Other
To select a presentation, select an available time slot. The time slot selected will become bolded, indicating that the presentation has been successfully scheduled. To change the scheduled time, select another available time slot. To remove a selected presentation, click on the bold slot again. Each student may only have one time slot to present.

## Professor Page

### Info
This page is intended for use by Computer Science professors that wish to view or sign up for the presentations times that the students have selected.

### How to Use
Navigate to the `Professor` tab by selecting it on the left. There will be a grid of student presentation times (as selected by the department chair) with the dates at the top of each column and the times within each box. Boxes with greyed out text have not been chosen by a student, and are thus labeled `No Student`. Boxes with black text indicate a student will be presenting at that time, and are labeled with the username of the student that selected them.

## Department Chair Page

### Info
The Department Chair page is intended for use by the Computer Science department chair. It allows for the chair to select which dates are available for presentations, and what specific times are available for presentations, along with the length of presentation time.

### How to Use
Navigate to the Department Chair tab by selecting it on the left. There will be a calendar labeled `Date Select`, below it a grid labeled `Time Select`, and farther down labels for `Add Times` and `Archiving`. To select dates and times for presentations, begin by using the arrows in the calendar to navigate between months. Select one of the desired dates from the calendar. A pop-up will appear to give a block of times, which can be altered and refined after the initial selection. Fill in the desired start and end times for the whole day (for example, 03:00 PM and 7:30: PM) as well as the interval, which indicates how long each presentation will be presented for.

After confirming a date, you may select another date or scroll down to the `Time Select` section to change or save the available times. Each time is listed individually in the grid. Click `Delete` to get rid of a time, and select one of the entries in the `Time Start` or `Time End` column to alter it.

After selecting the dates and times for presentations, select the Confirm button under `Add Times` in order to submit the selected presentation windows. After confirmation in the pop-up, the new dates and times will be visible to students and professors.

### Other

If the user ever wishes to remove and save all the scheduled dates (such as when beginning to schedule for a new semester), selecting the Archive Presentation Database button under `Archiving` will move all current dates and times to the archive, and completely reset the current selection.

## Admin Page

### Info
The Admin page is intended for use by a Computer Science administrator, allowing them to view and alter the database. Navigate to the `Admin` tab by selecting it on the left.

### How to Use
Under `Database Access`, there is a drop-down menu with the different accessible data sets. Select it to view what is available, then click on the label for the relevant data to open it. Options should include capstone_presentations (which has information about the current presentation schedule) and capsone_presentations_archive (which contains information from previous schedules).

In the grid of entries, selecting delete will remove that time slot and all of its data. Specific information can also be altered by selecting it in the grid and typing or selecting the new information. After changing the data, click the Save button in that entry to save the changes. If the user ever wishes to remove and save all the scheduled dates (such as when beginning to schedule for a new semester), selecting the Archive Presentations button under `Archiving` will move all current dates and times to the archive, and completely reset the current selection.
