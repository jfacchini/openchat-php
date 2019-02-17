# Cleancoders Openchat in PHP

In this repository I wanted to re-implement this Api using Outside-In style.
I'm following the source code of https://github.com/sandromancuso/cleancoders_openchat/tree/openchat-outside-in
to strictly follow the same design, the goal is to use the same steps for the Outside-In
style but at a later stage I'd like to change a bit the design to experiment my vision
of Hexagonal Architecture.

When I was looking around to see whether anyone else had this idea
I actually found someone that made some notes and write down their thoughts
about the series: https://gist.github.com/xpepper/2e3519d2cb8568a0b13739d9ae497f21.
I quite liked the beginning, so will back to it for each part of the implementation.

## Things I discovered

- RestAssured: Not sure if such a library exists in PHP but I've made a simple and quick
implementation. I really like the simplicity of making API calls. I'm wrapping
the Symfony Client that simulates HTTP calls.
- Hamcrest: I've discovered this library by read the book "Growing Object-Oriented Software
Guided By Test" but here is the first time I'm actually using it. I don't want yet to
install the PHP version, I thought that for now I'll just create callable "matcher"
to be used in 
