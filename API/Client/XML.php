<?php
namespace Dfe\Dynamics365\API\Client;
# 2017-07-02
final class XML extends \Dfe\Dynamics365\API\Client {
	/**
	 * 2017-07-02
	 * @override
	 * @see \Dfe\Dynamics365\API\Client::accept()
	 * @used-by \Dfe\Dynamics365\API\Client::headers()
	 */
	protected function accept():string {return 'xml';}
}