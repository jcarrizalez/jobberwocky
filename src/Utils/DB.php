<?php 
declare( strict_types = 1 );
namespace Avature\Utils;

use Closure;
use Illuminate\Support\Facades\DB AS FacadeDB;

/**
 * @method static \Illuminate\Database\Query\Builder table(string $table)
 * @method static mixed transaction(\Closure $callback, int $attempts = 1)
 * @method static \Illuminate\Database\ConnectionInterface connection(string $name = null)
 *
 * @method static string getDefaultConnection()
 * @method static void setDefaultConnection(string $name)
 * @method static \Illuminate\Database\Query\Expression raw($value)
 * @method static mixed selectOne(string $query, array $bindings = [])
 * @method static array select(string $query, array $bindings = [])
 * @method static bool insert(string $query, array $bindings = [])
 * @method static int update(string $query, array $bindings = [])
 * @method static int delete(string $query, array $bindings = [])
 * @method static bool statement(string $query, array $bindings = [])
 * @method static int affectingStatement(string $query, array $bindings = [])
 * @method static bool unprepared(string $query)
 * @method static array prepareBindings(array $bindings)
 * @method static void beginTransaction()
 * @method static void commit()
 * @method static void rollBack()
 * @method static int transactionLevel()
 * @method static array pretend(\Closure $callback)
 *
 * @see \Illuminate\Database\DatabaseManager
 * @see \Illuminate\Database\Connection
 */
class DB extends FacadeDB
{
	public function table(string $table)
	{
		return 	FacadeDB::table($table);
	}

	public function transaction(Closure $callback, int $attempts = 1)
	{
		return 	FacadeDB::transaction($callback, $attempts);
	}

	public function connection(string $name = null)
	{
		return 	FacadeDB::connection($name);
	}
}