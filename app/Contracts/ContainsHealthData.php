<?php

namespace App\Contracts;

/**
 * Marks a model that holds health data (art. 9 GDPR).
 *
 * The generic "admins can do everything" gate is not applied to these models:
 * only their policy decides who can see them.
 */
interface ContainsHealthData
{
}
