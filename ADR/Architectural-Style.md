# Decision of the suitable Architectural Style

## Context and Problem Statement
Designing a multi-tenant Complaint Management System (CMS) for ABC limited that allows Banking and Telecom companies to report, document and resolve complaints received by their respective customers.
ABC requires a system that streamlines complaint management and resolution through different access points such as web, mobile and telephone services. Users of the bank or telecom company will log a problem then get/log the resolution of the problem utilising the system to manage the lifecycle. The system must be available 24/7 (excluding telephone) and be designed in such a way that a chatbot can be incorporated in the future to solve problems for the helpdesk agents.
The system must ensure reliability, scalability (projected 20 million customers as projected by Barclays Investor Update 2024), ease of use, accessibility following the WCAG Level 2 and security following the GDPR.

## Considered Architectural Styles

* Three-Tier 
* Monolith (MVC) 
* General web application

## Decision Outcome
Monolith (MVC)

### Consequences

* Good, because this style offers a high degree of scalability as each layer (model, view, controllers) are seperated from each other into physical or virtual tiers. This typically means that each layer can be developed, tested and maintained independantly and if one layer experiences high traffic or volume resources can be allocated only to where they are required. Furthermore, with the seperation of presentation and database layers this means they can only communicate through the application layer, preventing users from directly accessing the database.
* Bad, if the system is not designed efficienctly the layers may become too dependant on each other which reduces the scalability as it would be more difficult to scale any specific part as it will affect other layers. Furthermore the increased complexity could work against the system and prove to be more difficult to maintain, develop and test as a process will involve multiple layers to work.
