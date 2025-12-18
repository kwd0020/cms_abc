# Selection of the Database Technology

## Context and Problem Statement
Due to the nature of the clients (Banking and Telecom Companies), ABC(Limited) requires a multi-tenant Complaint Management System which complies to GDPR practices to ensure users' personal data remains secure and confidential. Furthermore, it is also possible that future tenants may join the system therefore the database must be designed in such a way that allows a new tenant to seamlessly integrate into the system. To ensure compliance with GDPR the system shall perform backups and "ensure data integrity" to prevent data loss and data isolation must be implemented to prevent tenants from accessing others data..
## Considered Frontend Technologies

* MySQL, Relational 
* PostgreSQL, Relational 
* MariaDB, Relational
* MongoDB, Non-Relational

## Decision Outcome
PostgreSQL
### Consequences

* Positive, provides multi-tenancy support through seperation of either database, schemas or tables depending on the level of data isoltation required. Directly supports horizontal scaling to ensure non-functional requirements are met to allow new tenants to be added later. Compatability with PHP and Laravel.
* Negative, Less familiarity than with mySQL meaning time must be taken to learn how to properly integrate into system. No built-in multi-tenant support increasing the complexity of implementation as it may affect application layer. 
