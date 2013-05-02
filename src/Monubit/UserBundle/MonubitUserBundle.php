<?php

namespace Monubit\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonubitUserBundle extends Bundle
{
	public function getParent() {
		return 'FOSUserBundle';
	}
}
