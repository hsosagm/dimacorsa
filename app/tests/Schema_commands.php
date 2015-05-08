<?php
Schema::create('users' , function($table)
{
$table->increments('id'); Incrementing ID to the table (primary key).
$table->string('email'); VARCHAR equivalent column
$table->string('name', 100); VARCHAR equivalent with a length
$table->integer('votes'); INTEGER equivalent to the table
$table->bigInteger('votes'); BIGINT equivalent to the table
$table->smallInteger('votes'); SMALLINT equivalent to the table
$table->float('amount'); FLOAT equivalent to the table
$table->decimal('amount', 5, 2); DECIMAL equiv with a precision and scale
$table->boolean('confirmed'); BOOLEAN equivalent to the table
$table->date('created_at'); DATE equivalent to the table
$table->dateTime('created_at'); DATETIME equivalent to the table
$table->time('sunrise'); TIME equivalent to the table
$table->timestamp('added_on'); TIMESTAMP equivalent to the table
$table->timestamps(); Adds created_at and updated_at columns
$table->softDeletes(); Adds deleted_at column for soft deletes
$table->text('description'); TEXT equivalent to the table
$table->binary('data'); BLOB equivalent to the table
$table->enum('choices', array('foo', 'bar')); ENUM equivalent to the table
$table->string('name')->after('email');
$table->engine = 'InnoDB';
$table->foreign('user_id')->references('id')->on('users'); adding a foreign key
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
$table->dropForeign('posts_user_id_foreign'); drop the foreign key
/*
Note: When creating a foreign key that references an incrementing integer, remember to always make
the foreign key column unsigned.
*/
// Create an Index for speed or foreign key support .
$table->string('email')->unique(); During column definition
// Or, you may choose to add the indexes on separate lines
$table->primary('id') ; Adding a primary key
$table->primary(array('first', 'last')); Adding composite keys
$table->unique('email'); Adding a unique index
$table->index('state'); Adding a basic index
// Droping Indexes
$table->dropPrimary('users_id_primary'); Dropping a PK from the "users" table
$table->dropUnique('users_email_unique'); Dropping a unique index from the "users" table
$table->dropIndex('geo_state_index'); Dropping a basic index from the "geo" table
->nullable() Designate that the column allows NULL values
->default($value) Declare a default value for a column
->unsigned() Set INTEGER to UNSIGNED
});
//To rename an existing database table
Schema::rename($from, $to) ;
// Rename a column
Schema::table('users', function($table)
{
$table->renameColumn('from', 'to');
});
//To drop a table
Schema::drop('users') ;
Schema::dropIfExists('users') ;
// Drop a column from a table
Schema::table('courses', function($table)
{
$table->dropColumn('description');
});
// Drop multiple columns
Schema::table('users', function($table)
{
$table->dropColumn('votes', 'avatar', 'location');
});
// Add an extra column (email)
Schema::table('users' , function($table)
{
$table->string('email') ;
});
// Defining Storage Engine
Schema::create('users', function($table)
{
$table->engine = 'InnoDB';
$table->string('email');
});
########################## Sentry's migrations ########################
Schema::create('users', function($table)
{
$table->increments('id');
$table->string('email');
$table->string('password');
$table->text('permissions')->nullable();
$table->boolean('activated')->default(0);
$table->string('activation_code')->nullable();
$table->timestamp('activated_at')->nullable();
$table->timestamp('last_login')->nullable();
$table->string('persist_code')->nullable();
$table->string('reset_password_code')->nullable();
$table->string('first_name')->nullable();
$table->string('last_name')->nullable();
$table->timestamps();
// We'll need to ensure that MySQL uses the InnoDB engine to
// support the indexes, other engines aren't affected.
$table->engine = 'InnoDB';
$table->unique('email');
$table->index('activation_code');
$table->index('reset_password_code');
});
Schema::create('groups', function($table)
{
$table->increments('id');
$table->string('name');
$table->text('permissions')->nullable();
$table->timestamps();
// We'll need to ensure that MySQL uses the InnoDB engine to
// support the indexes, other engines aren't affected.
$table->engine = 'InnoDB';
$table->unique('name');
});
Schema::create('users_groups', function($table)
{
$table->integer('user_id')->unsigned();
$table->integer('group_id')->unsigned();
// We'll need to ensure that MySQL uses the InnoDB engine to
// support the indexes, other engines aren't affected.
$table->engine = 'InnoDB';
$table->primary(array('user_id', 'group_id'));
});
Schema::create('throttle', function($table)
{
$table->increments('id');
$table->integer('user_id')->unsigned();
$table->string('ip_address')->nullable();
$table->integer('attempts')->default(0);
$table->boolean('suspended')->default(0);
$table->boolean('banned')->default(0);
$table->timestamp('last_attempt_at')->nullable();
$table->timestamp('suspended_at')->nullable();
$table->timestamp('banned_at')->nullable();
// We'll need to ensure that MySQL uses the InnoDB engine to
// support the indexes, other engines aren't affected.
$table->engine = 'InnoDB';
}); 