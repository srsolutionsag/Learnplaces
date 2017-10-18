The dao package contains data access objects which interact with the active record
entities to fetch, store, delete and update data.

A dao is wrapped with a caching aspect to minimize the direct database hits.
Only the repositories which abstract the database access further are interacting
with classes from this package. 