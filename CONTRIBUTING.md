# Contributing

When contributing to this repository, please first discuss the change you wish to make via issue,
email, or any other method with the owners of this repository before making a change. 

Please note we have a code of conduct, please follow it in all your interactions with the project.

## Pull Request Process

- Create a personal fork of the project on Github.
- Clone the fork on your local machine. Your remote repo on Github is called `origin`.
- Add the original repository as a remote called `upstream`.
- If you created your fork a while ago be sure to pull upstream changes into your local repository.
- Create a new branch to work on! Branch from `develop`.
- Implement/fix your feature, comment your code.
- Follow the code style ps2 and ps4 for your code
- Write or adapt tests as needed.
- Squash your commits into a single commit with git's [interactive rebase](https://help.github.com/articles/interactive-rebase)
- Push your branch to your fork on Github, the remote `origin`.
- From your fork open a pull request in the correct branch. Target the project's `develop` branch.
- Once the pull request is approved and merged you can pull the changes from `upstream` to your local repo and delete
your extra branch.

## Branch Name
- The branch used to implement the new feature starts with prefix `feature/`.
- The branch used to fix the bug starts with the prefix `bugfix/`.

## Commit and commit messages
- Don't bundle too many changes into one commit.
- Each branch only commits code related to the current feature/bug being fixed.
- The commit message must fully describe the changes in the commit.

## Rules for branching and merging
- The branch must be forked from `develop`.
- Do not continue from the branch that was merged into develop, but have to split again from `develop`.
- Do not merge sub-branches together.
- Each commit can't have too many changes, just make sure the code builds and runs, if it doesn't build or run, add WIP: at the beginning of the commit message.
- Make sure the code runs without build errors before creating the Pull Request.

## Other regulations
- Need to fetch, check and pull/reset when returning to work on an old branch.
- Avoid comments with the purpose of turning off lines of code, any code that is no longer in use should be deleted.
- Should rebase to develop branch often and before creating Pull Request.
- Must use rebase to handle conflicts.


