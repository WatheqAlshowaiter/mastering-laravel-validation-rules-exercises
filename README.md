## Mastering Laravel Validation Rules - Exercises

### Welcome!

Reading about a skill is one way to learn, but there's incredible value in practicing a new skill as well. Translating what you've learned into action helps you cement your knowledge and become more proficient.

The exercises are arranged roughly in order of complexity, from easiest to hardest, but there's no requirement to work them in a specific order. Also, there's some benefit in repetition. Even after solving them all, come back periodically and solve them again. This will deepen your knowledge retention.

We're so glad you're willing to try these exercises out. Please send us feedback on your experience: Were the exercises helpful? Too easy or too hard? Anything confusing? Contact information is at the bottom of this document.

### Installation

All you need on your machine is PHP 8.0.2 (or higher) and Composer.

PDO and PDO_SQLITE are also required, but they're enabled by default in PHP, so no special build or configuration should be required. For simplicity, all database access uses an in-memory SQLite database.

From the project root, run the following commands to install dependencies and set up the environment:
* `composer install`
* `composer run post-root-package-install`
* `composer run post-create-project-cmd`

### Exercise List

-   1 - Allow students to start registration
-   2 - Allow user to change their password
-   3 - Create a new tournament season
-   4 - Request game supplies
-   5 - Post a skill to a job board
-   6 - Shipping and receiving processing
-   7 - Allow in-person registration for trivia game
-   8 - Submit a score sheet for a trivia game
-   9 - Register a team with captain and players
-   10 - Create a scheduled task

## Working an exercise

Let's say you want to work exercise 1 - Allow students to start registration

1. Start by reading the requirements `php artisan exercise:show 1`
2. Note the functional requirements. These describe the high-level requirements as you might receive them from a client or project manager.
3. Review the request fields and database schema. The request fields are essential as you write your validation rules. The schema may also make you think about other validation rules you want to write.
4. Open the Form Request file mentioned at the bottom of the requirements.
5. Some form requests have additional notes inside them.
6. Fill out the `rules()` method with the necessary rules to both meet the functional requirements, but also to guard against malicious or messy data.
7. When you think you've got it solved, grade the exercise `php artisan exercise:grade 1`

You'll see a list of pass and fail notices. If something fails, go back to your rules and think about what might be missing.

If you're not sure why something is failing, check the hints `php artisan exercise:grade 1 --hints`. Don't jump to this too quickly. Part of the benefit of the exercises is to bump into some walls and work your way through them. This will help you understand how it works better, and help you retain the information.

If you're really stuck, or if you just want to compare notes, you can check the `app/Solutions` folder for your exercise.

> NOTE: There are a lot of different ways to write validation rules. We tried really hard to anticipate alternate valid ways of building the rules, but if you've got a solution that you think works, but isn't passing, please share it with us.
>
> We welcome any feedback! Send comments, alternate solutions, or questions to <a href="mailto:hello@nocompromises.io">hello@nocompromises.io</a>

### Release Notes

- v2.0 - Bump version to match 2nd edition of book release.
- v1.2 - Upgrade for Laravel 9
- v1.1 - Add 4 new exercises, improve syntax error handling in grading.
- v1.0 - Initial release of first 6 exercises
