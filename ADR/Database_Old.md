# Selection of the Database Technology

## Context and Problem Statement
Due to the nature of the clients (Banking and Telecom Companies), ABC(Limited) requires a multi-tenant Complaint Management System which complies to GDPR practices to ensure users' personal data remains secure and confidential. Furthermore, it is also possible that future tenants may join the system therefore the database must be designed in such a way that allows a new tenant to seamlessly integrate into the system. To ensure compliance with GDPR the system shall perform backups and "ensure data integrity" to prevent data loss and data isolation must be integrated to every tenants.
## Considered Frontend Technologies

* MySQL, Relational 
* PostgreSQL, Relational 
* MariaDB, Relational
* MongoDB, Non-Relational

## Decision Outcome
MySQL
### Consequences

* Positive, provides multi-tenancy support through seperation of database, schemas or tables to ensure non-functional requirements are met. Supports scalability through addition of resources to a server as well as role-based access control and user authentication helping maintain tenant data isolation to comply with GDPR regulations.
* Negative, Multi-tenant management can be complex if handled poorly and may negatively impact performance of the sytem. A large amount of concurrent updates may hinder the performance of the database which could have furhter negatvie implications for the wider system.
