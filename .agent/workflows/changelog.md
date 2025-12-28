---
description: track every changes
---

# Changelog Workflow

## Description

After making any changes to the Rentify project files, update the `CHANGELOG.md` file to track all modifications.

## Instructions

1. After completing any code changes, update `c:\laragon\www\rentify\CHANGELOG.md`
2. Use the following format for each entry:

    - Date in `YYYY-MM-DD` format
    - Category: `Added`, `Changed`, `Fixed`, `Removed`, `Security`
    - Brief description of the change
    - Files affected (if relevant)

3. Group entries by date, with most recent at the top
4. Be concise but descriptive enough to understand what changed

## Example Entry Format

```markdown
## [2025-12-28]

### Changed

-   Updated sidebar icons from Bootstrap Icons to Font Awesome 7 (`templates/element/sidebar.php`, `templates/element/public_sidebar.php`)
```
