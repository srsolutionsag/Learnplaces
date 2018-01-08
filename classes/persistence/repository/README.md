The repositories making use of the dao package to manipulate data.
The repositories only provide methods needed to access the data in specific way.
Furthermore the active records are mapped to a "better" relation and proxied to
safe resources.

The upper layers are only supposed to talk to the repositories but never to dao
or entities directly.