<p>Its my small project.</p>
<p>For local check run code climate:</p> 
./vendor/bin/phpcs --standard=PSR2 $(git diff-tree --no-commit-id --name-only --diff-filter=ACM -r HEAD)
<p>For automatic fix run:</p>
./vendor/bin/phpcbf --standard=PSR2 $(git diff-tree --no-commit-id --name-only --diff-filter=ACM -r HEAD)