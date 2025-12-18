# Decision of the Backend Framework/Technologies

## Context and Problem Statement
Designing and developing a multi-tenant Complaint Management System following a layered monolithic approach while ensuring 24/7 operation with responsive design and real-time ticket status. The performance, scalability and confidence developing with the considered technologies will significantly impact the decision. The architectural decision involves selecting possible frameworks that can be used to develop a layered monolith.
## Considered Technologies

* PHP(Laravel, Websockets)
* Node.js
* Python(Django)

## Decision Outcome
PHP(Laravel, Websockets)

### Consequences
* Positive, Laravel provides a wide variety of packages that can support development such as laravarel multi-tenancy. Real-time updates can be provided using WebSockets to meet non-functional requirements of the system. High degree of seperation of concerns can be achieved through Laravel repositories/service classes. 
* Negative, PHP inherently has performance degradation with high user concurrency due to each request being isolated. Codebase may become difficult to maintain if seperation of layers become tightly-coupled which would also negatively impact the scalability of the system as an update may require multiple layers to be addressed.
