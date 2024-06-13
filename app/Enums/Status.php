<?php

namespace App\Enums;

class Status {
	/* User Status */
    const ENABLE    = 1;
    const DISABLE   = 0;

	/* Inventory Status */
	const IDEA 		 = 1;
	const READY 	 = 3;
	const INPROGRESS = 2;
	const COMPLETED	 = 0;

	/* Support Status */
	const OPEN 		 = 1;
	const CLOSED 	 = 2;

	const CUSTOMER_CREATED = 1;
	const CUSTOMER_UPDATED = 2;
	const PROFILE_UPDATED  = 3;
	const PASSWORD_UPDATED = 4;

	/* Status Codes */
	const INTERNAL_ERROR = 500;
	const SUCCESS		 = 200;
}

?>