<?php
declare( strict_types = 1 );
namespace Avature\Utils;

final class Paginator
{
	protected int $count;
	
	protected int $page;

	public function __construct(array $params)
	{
		$this->count = (int) ($params['count'] ?? 10);

		$this->page = (int) ($params['page'] ?? 1);
	}

	public function getCount(): int
	{
		return $this->count;
	}

	public function getPage(): int
	{
		return $this->page;
	}

	public function toString(): string
	{
		return "count={$this->count}&page={$this->page}";
	}
}