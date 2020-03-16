<?php

/*
 * This file is part of fof/default-group.
 *
 * Copyright (c) 2018 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace FoF\DefaultGroup\Listeners;

use Flarum\Group\Group;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Activated;
use Flarum\User\User;

class AddDefaultGroup
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @param SettingsRepositoryInterface $settings
     */
    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function handle(Activated $event) {
        $defaultGroup = $this->settings->get('fof-default-group.group');

        $domain = "@illinois.edu";
        $len = strlen($domain);
        // error_log(substr($event->user->email, -$len));

        if ($defaultGroup != null && (int) $defaultGroup !== Group::MEMBER_ID && substr($event->user->email, -$len) === $domain) {
            $event->user->groups()->attach($defaultGroup);
        }
    }
}
