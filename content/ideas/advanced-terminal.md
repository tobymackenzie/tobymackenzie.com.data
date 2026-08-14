---
date: 2026-08-09T20:39:00-05:00
tags: [cli,computer,software]
---

Advanced terminal
=================

Each command output would be stored as separate visual object, separated by border / block, command as title, could be folded to hide output. Output item could be acted on eg copied to OS clipboard, saved to file, copied to separate pane.

Separate input field for entering commands, would be pushed to output window.  Input panel would expand for multiline input.  Actual shell program might be in input field.  Content of output pane would be a copy, and the input pane would essentially be cleared after each command.  Alt screen and interactive commands would cause output to shrink, input pane expand, behave like normal terminal until exit of command, output wouldn't be saved to output pane but single line with command would.

Keyboard and mouse movement available for all actions.  Border highlights currently focused pane, keys to switch between, quick key (perhaps escape) to get back to input pane.

Button sidebar with gui helpers to build commands common for current context. Would show custom form like builder at top of input field, show built command below, until command run. Normal context would have common file commands, etc. Projects could define their own commands via config file, those buttons would show when in that dir or subdirs. Command arguments,  options would likely be limited to common ones, maybe have "more" button for others.

A bookmark panel would allow quickly cding to favorite dirs or running common commands.

Files panel would list current directory, click to open or cd. 

Could clone output of a command to a pane that would stay next to main output pane until closed. 

Help pane could be opened showing common commands, access to man pages and tutorials. Panes could be moved or maximized as overlay over other panes for smaller screens.

Whole thing could possibly be done as tui, but might take a lot of space for all the panes with character size dividers. 
