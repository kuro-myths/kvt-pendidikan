<?php
// @formatter:off
// phpcs:ignoreFile

/**
 * IDE Helper for Laravel - auth() helper type resolution.
 * This file is not included in production, it exists only for IDE support.
 */

namespace Illuminate\Contracts\Auth {

    interface Guard
    {
        /**
         * @return \App\Models\User|null
         */
        public function user();

        /**
         * @return bool
         */
        public function check();

        /**
         * @return bool
         */
        public function guest();

        /**
         * @return int|string|null
         */
        public function id();

        /**
         * @return bool
         */
        public function validate(array $credentials = []);

        /**
         * @return bool
         */
        public function hasUser();

        /**
         * @return void
         */
        public function setUser(Authenticatable $user);
    }

    interface StatefulGuard extends Guard
    {
        /**
         * @return bool
         */
        public function attempt(array $credentials = [], $remember = false);

        /**
         * @return bool
         */
        public function once(array $credentials = []);

        /**
         * @param \App\Models\User|Authenticatable $user
         * @return void
         */
        public function login(Authenticatable $user, $remember = false);

        /**
         * @return \App\Models\User|Authenticatable|false
         */
        public function loginUsingId($id, $remember = false);

        /**
         * @return bool
         */
        public function onceUsingId($id);

        /**
         * @return bool
         */
        public function viaRemember();

        /**
         * @return void
         */
        public function logout();
    }

    interface Factory
    {
        /**
         * @param string|null $name
         * @return Guard|StatefulGuard
         */
        public function guard($name = null);
    }
}
