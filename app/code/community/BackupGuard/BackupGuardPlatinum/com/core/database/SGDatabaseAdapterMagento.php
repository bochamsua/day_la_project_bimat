<?php
require_once(SG_DATABASE_PATH.'SGIDatabaseAdapter.php');

class SGDatabaseAdapterMagento implements SGIDatabaseAdapter
{
	private $link = null;

	public function __construct()
	{
		$resource = Mage::getSingleton('core/resource');
        $this->link = $resource->getConnection('core_write');
	}

	public function query($query, $params=array())
	{
		$st = $this->exec($query, $params);
		if (!$st)
		{
			return false;
		}

		$op = strtoupper(substr(trim($query), 0, 6));
		if ($op!='INSERT' && $op!='UPDATE' && $op!='DELETE' && $op!='SET NA')
        {
			return $st->fetchAll();
		}

		return true;
	}

	public function exec($query, $params=array())
    {
    	$query = str_replace("%d", "?", $query);
		$query = str_replace("%s", "?", $query);
		$query = str_replace("%f", "?", $query);

		$st = $this->link->prepare($query);
		$res = $st->execute($params);
		if (!$res)
		{
			return false;
		}

		return $st;
    }

    public function fetch($st)
    {
        if ($st)
		{
			return $st->fetch();
		}
    }

	public function lastInsertId()
	{
		return $this->link->lastInsertId();
	}

	public function printLastError()
	{
		print_r($this->link->errorInfo());
	}
}
