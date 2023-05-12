# Project and Code Report

## Agility (Kanban)
We utilized the Kanban methodology to manage our project's progress and keep track of issues and tasks. We implemented this methodology by utilizing the GitHub Projects feature, which allowed us to organize and track issues in a Kanban-style structure.

Using GitHub Projects, we were able to create different columns for each stage of our development process, such as `To Do`, `In Progress`, and `Done`. We then assigned issues and tasks to the appropriate column, giving us a clear and organized view of our progress.

This approach allowed us to quickly and easily see which tasks were in progress, which ones were complete, and which ones still needed to be started. It also enabled us to assign tasks to team members and track their progress, ensuring that everyone was on the same page and working towards our project's goals.

Using the Kanban methodology through GitHub Projects allowed us to manage our project efficiently and effectively while ensuring that we met our deadlines and goals.

## User Stories

### User Story 1

#### Scenario
The professor wants to view when students are presenting during a certain capstone presentation date. Professor is linked to the capstone scheduling access through the main capstone website. The professor navigates through the taskbar to the student signup menu. The professor arrives on a page showing the first date of capstone presentation, but wants to look at the third date. The professor selects the drop down menu from the top right corner, and clicks on the date they desire. The professor then can see the available times and when students are presenting, and may scroll down to see times through the whole day. When the professor is done viewing, they select the home button in the taskbar to return to the main capstone system.

#### Test Case
Professor wants to find a specific student but doesn’t know what date or time they’ve signed up for. One possible solution would be to provide a search bar to search through student names, displaying their scheduled date and time if they have already signed up. However, this is outside the scope of the project.

### User Story 2

#### Scenario
Professor sets up scheduled times for presentations and removes already scheduled students. Professor is linked to the capstone scheduling access through the main capstone website, and they navigate to the admin page. They select which dates they would like on the calendar to be capstone presentation days. Then in the table for those days they specify time frames in which people can schedule their presentations. The professor presses confirm to save their choices. Then, the professor uses the taskbar to navigate to the student signup menu. They select the date they desire using the dropdown, and scroll to find the relevant time and student. Then they select the remove button to remove the student from the presentation schedule. Finally, the professor selects home to navigate back to the capstone page.

#### Test Case

Department chair accidentally selects a student and deletes them from the current scheduled presentations. An implementation to prevent this from occurring needs to be done. Maybe a popup window to prevent this.

The professor tries to leave the scheduling page without confirming their choices. Again, a popup could help by ensuring the professor knows they haven’t confirmed their choices, still allowing them to leave if they want.

### User Story 3

#### Scenario

Student schedules presentation. Student is linked to the capstone scheduling access through the main capstone website and arrive on the date select page. The page shows what times are or are not available. If a time is not available it will be grayed out.  The student selects a time when they want to give their Capstone presentation and double clicks it to select.

#### Test Case
The student accidentally double clicks a date they did not mean to select. A popup will show up to make sure the user meant to select the date they selected.

## User Interface Design
In the development of the capstone presentation project, we placed significant emphasis on the importance of consistent user interface design. The objective was to provide users with a seamless and intuitive experience. One crucial aspect of our approach was ensuring that the application had a consistent theme, with a well-defined layout, typography, and color scheme.

In pursuit of our goal, we carefully selected a theme that was not only visually appealing but also easily navigable. This enabled us to apply the theme consistently across all components and pages of the application, fostering a sense of familiarity and ease of use for the users.

Moreover, the use of color was deliberate and purposeful. We meticulously selected a color scheme that was aesthetically pleasing, while ensuring that it was accessible to all users. We decided to use a purple theme throughout the application, as purple is one of Truman's official colors. By using this color scheme, we were able to create a visual connection between our project and Truman State University, making the application feel more personalized and relevant to our target audience. Our decision to apply color consistently throughout the application enabled users to easily distinguish between different elements of the interface, with specific colors assigned to represent distinct actions or states.

We were also committed to adhering to correct user interface design principles. This included principles such as consistency, feedback, and affordance, which ensured that users could comprehend the actions available to them and the potential outcomes of those actions. For instance, we made sure to use clear and consistent button labels and icons, while providing visual feedback to signify completed actions, and ensuring that clickable elements were readily recognizable.

## Security

### Cookies
The original online capstone system uses Truman's Central Authentication System (CAS) for user authentication. CAS is a widely used single sign-on solution that allows users to access multiple applications with a single set of login credentials. The CAS authentication process involves redirecting the user to a CAS server for
authentication and then redirecting the user back to the original application with a cookie that verifies the user's identity.

To modify the original capstone system, the PHP file that controls the CAS (phpCAS) is modified. A new cookie is created that stores the current username of the user, which is then read by the program to determine the user's identity. This modification enables the system to identify the user without requiring them to repeatedly authenticate themselves.

The modified capstone system uses the user's identity to control access to different functionalities. The server blocks any functionality that does not match the user's username. For instance, if a student tries to access the professor or admin pages, they will be denied access because their username does not match the corresponding functionality.

The modification to the original capstone system helps to improve its functionality and enhance its security. By using cookies to store user identities, the system avoids requiring users to authenticate themselves repeatedly. Additionally, the modified system ensures that only authorized users can access specific features, preventing unauthorized access and maintaining the security of the system.

### Defaults and Instability
In many cases, software systems allow users to change various settings or configurations within the application. While this can be beneficial for customizing the application to specific needs or preferences, it can also increase the security risk associated with the application. If users are not familiar with the security implications of various settings, they may unwittingly make changes that weaken the system's security.

In the case of the modified capstone system, the system has been designed so that it cannot be changed within the application. This means that the system's defaults are always the most secure defaults, and users cannot modify them in any way that might inadvertently weaken the system's security.

By not allowing users to change system settings within the application, the system maintains a consistent and secure configuration. Users do not have to worry about making changes that might inadvertently introduce vulnerabilities or weaken the system's security. Instead, they can focus on using the system's features to manage their capstone projects without having to worry about the system's security.

Furthermore, by not allowing users to change system settings within the application, the system administrators can ensure that the system remains secure and up-to-date. They can monitor the system and make any necessary security updates or patches without having to worry about users making changes that might interfere with the system's security.

### Potential Security Risk Analysis
SQL injections which are common among websites are not possible under the current system. All vulnerabilities associated with the capstone website would be from the Truman CAS system. Potential cookie swapping is possible if someone were to gain the access token to the website from a user's computer. However, that would not just compromise the current website, but all websites which store cookies as a form of authentication. Meaning, any security vulnerabilities will not be the direct fault of this project.

## Tools

### Vite
Vite was utilized in the Truman Computer Science capstone presentation scheduling website to enhance the performance and streamline the development workflow of our application. Vite is a fast and lightweight build tool that is highly customizable and designed to optimize the development experience while reducing build times.

One of the significant advantages of Vite is its utilization of modern web technologies, such as ES modules, for faster and more efficient bundling of code. Vite also supports hot module replacement, enabling developers to view code changes without the need to refresh the page.

Vite supports several file formats, including TypeScript, CSS preprocessors, and markdown, making it versatile and customizable. Additionally, Vite offers a user-friendly configuration system that enables developers to quickly and easily adjust the build settings to suit their requirements.

By utilizing Vite in our project, we were able to significantly reduce build times and improve the performance and development experience of our application. Vite's support for modern web technologies, such as ES modules, and its highly customizable configuration system made it an ideal choice for our project.

### NodeJS
Node.js played a pivotal role in the development of our project. Specifically, leveraging the power of Node.js to manage the numerous packages that were essential to the project was vital. Using the Node.js package manager, npm, allowed us to easily install and manage various packages such as Prisma for efficient database management, Prettier for consistent code formatting, Tailwind for fast and responsive UI styling, and Playwright for reliable end-to-end testing.

The success of our project was greatly aided by the flexibility and efficiency provided by Node.js. We took advantage of the rich ecosystem of packages available through npm and utilized custom scripts to streamline our development workflow. As a result, we developed a robust and performant application that effectively met the needs of our users.

### Playwright
Playwright is a Node.js library that was utilized in the Truman Computer Science capstone presentation scheduling website for end-to-end testing. Playwright is an automation tool that enables developers to simulate user interactions with web applications and automate the testing process.

One of the primary benefits of Playwright is its cross-browser compatibility, which includes support for popular browsers like Chrome, Firefox, and Safari. Playwright also offers a simple and intuitive API that allows developers to write and maintain automated tests with ease.

Another notable feature of Playwright is its support for modern web technologies such as WebSockets, WebRTC, and Service Workers, making it a versatile and adaptable tool for testing web applications.

By utilizing Playwright in the project, the reliability and accuracy of the automated testing process was improved, ensuring the quality and performance of the application. Its cross-browser compatibility, intuitive API, and support for modern web technologies made it the optimal choice for the project.

### Prettier
Prettier is a popular code formatting tool that we used in our project. Prettier automatically formats code to ensure that it adheres to consistent style guidelines, which helps to improve the readability and maintainability of our codebase. By integrating Prettier into our development workflow, we were able to ensure that our code followed a consistent and professional style without spending additional time on manual formatting. Prettier also allowed us to customize the formatting rules to meet our specific requirements, such as line length and indentation, to ensure that our codebase met our high standards.

## Libraries

### SvelteKit
After careful consideration, we selected SvelteKit as the framework of choice for the CS capstone presentation scheduling website. The rich toolset and conventions offered by SvelteKit streamlined the development process, making it easier to build server-rendered web applications on both the front and backend.

One significant benefit of leveraging SvelteKit was the ability to write components using HTML, CSS, and JavaScript syntax, thereby accelerating the creation of the frontend. Moreover, the built-in support for server-side rendering, routing, and API endpoints in SvelteKit made it effortless to build a resilient backend that could handle scheduling requests and data processing.

In addition, SvelteKit offers excellent support for user authentication and session management, enabling us to implement a secure login feature that restricts access to authorized students and faculty members.

In summary, SvelteKit proved to be an excellent choice for our scheduling website, offering us a powerful and adaptable foundation for building server-rendered web applications that met our requirements. We highly recommend this framework to other developers looking to create similar applications quickly and efficiently.

### Svelte from SvelteKit
Svelte is a powerful frontend JavaScript compiler that offers developers an efficient and concise way of writing code. By minimizing the amount of runtime code that needs to be shipped to the browser, Svelte enables the creation of fast and responsive web applications.

To utilize Svelte in your project, you would first write your frontend code using Svelte syntax, which closely resembles that of HTML, CSS, and JavaScript. You would then use the Svelte compiler to convert your code into highly optimized JavaScript that is tailored for the browser environment.

One of the primary advantages of using Svelte for the frontend of your web application is the ability to write reusable components. This feature can save time and effort when building complex applications, as it reduces the amount of code that must be written and ensures consistency across the application.

By leveraging Svelte for the frontend of your project, you would have been able to deliver a user interface that is both fast and responsive, and that effectively meets the needs of your users.

### Prisma
Prisma was our chosen database toolkit and Object-Relational Mapping (ORM) for the project. Prisma's advanced features provided us with a modern and efficient way to access our SQL database through a type-safe API, perfectly suited for TypeScript and Node.js.

Prisma's declarative approach allowed us to define the structure of our database schema using its Schema Definition Language (SDL). This helped us to manage schema changes with ease using Prisma's built-in migration tools.

By leveraging Prisma's query building capabilities, we were able to create and execute queries in a type-safe manner, reducing runtime errors and improving the reliability of our application. Prisma's introspection feature also proved to be an invaluable asset, allowing us to explore our database schema and optimize our queries effectively.

Prisma was instrumental in simplifying our database access and optimizing the performance of our project. Its compatibility with modern frameworks and ease of use made it an excellent fit for our project.
