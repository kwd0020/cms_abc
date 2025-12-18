# Selection of the Frontend Framework

## Context and Problem Statement
Designing and developing a multi-tenant Complaint Management System following a layered monolithic approach for the codebase in which the frontend must follow accessibility standards (WCAG Level 2), while ensuring 24/7 operation with responsive design and real-time ticket status. The performance, scalability and confidence developing with the considered technologies will significantly impact the decision. The architectural decision involves selecting possible frameworks that can be used to develop a layered monolith.

## Guaranteed Technologies
* CSS
* HTML
* JavaScript

## Considered Frontend Technologies

* React with Next.js -  reusable components for ease of use, with fast performance.
* PHP with Laravel. (Including WebSockets for real-time updates, and AJAX for displaying changes)

## Decision Outcome
HTML and CSS styling for frontend using PHP with Laravel for communication with other layers within the system.

### Consequences

* Good, Provides server-side processing meaning an increase in load times if handled correctly. Integration of real-time ticket status updates is also possible through AJAX. Furthermore, a Multi-Tenant approach is also supported which can be used to satisfy non-functional requirements. Finally, this is the technology that I am most familiar with which will improve the development time during sprints and allow me to implement more complex solutions if needed.
* Bad, HTML and CSS makes it more difficult to re-use assets or components within the frontend when compared to react as it requires consistent programming of styles and interactions whereas components created with react can be re-used as is, reducing code complexity. Furthermore, PHP uses server requests for every user interaction which can negatively impact page performance and with the large projected userbase this could have a significant impact on the user experience.
