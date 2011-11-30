sfContextBehavior
=================

Example : log version author
----------------------------

``` xml
<database name="propel" defaultIdMethod="native" package="lib.model">
  <behavior name="sf_context" />

  <table name="user">
    <column name="id" type="INTEGER" required="true" primaryKey="true" autoIncrement="true" />
    <column name="name" type="VARCHAR" size="255" />
  </table>

  <table name="versioned_content">
    <column name="id" type="INTEGER" required="true" primaryKey="true" autoIncrement="true" />
    <column name="title" type="VARCHAR" size="255" />
    <column name="version_created_by" type="integer" required="false" />
    <foreign-key foreignTable="user" onDelete="cascade" phpName="VersionAuthor">
      <reference local="version_created_by" foreign="id" />
    </foreign-key>
    <behavior name="versionable">
      <parameter name="log_created_at" value="true" />
      <parameter name="log_created_by" value="true" />
      <parameter name="log_comment" value="true" />
    </behavior>
  </table>
</database>
```

update your Active record class ass follow

``` php
class VersionedContent extends BaseVersionedContent
{
	public function preSave(PropelPDO $con = null)
  {
    if (  ($sf_context = $this->getApplicationContext()) &&
          ($sf_user = $sf_context->getUser())) {
      $this->setVersionCreatedBy($sf_user->getId());
    }

    return true;
  }
}
```

And every new version will now log current user id if available !

Description
-----------

This behavior add context awareness to related object.

To access context, just call ```getApplicationContext()``` method.
If no context exists, then the method returns ```false```, otherwise context is returned.

This is added to Active record and active query objects

Installation
------------

Install the behavior in your vendor directory

```
git submodule add git://github.com/Carpe-Hora/sfContextBehavior.git lib/vendor/sfContextBehavior
```

add following to your ```propel.ini``` file:

``` ini
propel.behavior.sf_context.class               = lib.vendor.sfContextBehavior.src.sfContextBehavior
```

Declare behavior for the whole database in your ```config/schema.xml```

``` xml
<database name="propel" defaultIdMethod="native" package="lib.model">
  <behavior name="sf_context" />
</database>
```

or for a table only

``` xml
<database name="propel" defaultIdMethod="native" package="lib.model">
  <table name="my_table">
    <column name="id" type="integer" required="true" primaryKey="true" autoIncrement="true" />
    <behavior name="sf_context" />
  </table>
</database>
```
