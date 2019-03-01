# SEGS WebUI

## New Page Template

The file `template.php` (located in `<installation_directory>/public/assets/views/`) is available for creating
additional pages. Copy the template and make any desired changes. Edit
`<installation_directory>/public/assets/includes/menuLeft.php` to add a link to the new page. By default, there
is an example block of code for adding a new link, shown below.

```html
        <li id="menu_files" class="nav-item ">
            <a class="nav-link" href="?page=template.php">
                <i class="fab fa-file"></i>
                <p>Menu Name</p>
            </a>
        </li>
```

1. Change `href="?page=template.php` in the `<a>` tag to use the correct filename.
2. Change the icon (`<i>` tag) to display an appropriate [Font Awesome](https://fontawesome.com/) icon. You 
can use the [Font Awesome Cheatsheet](https://fontawesome.com/cheatsheet) to find an icon quickly.
3. Update `<p>Menu Name</p>` with an appropriate menu title.