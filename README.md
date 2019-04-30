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
to be used in my `Then` object to perform needed assertions.
- I cannot create a Mock from a final class. I've discovered that Prophecy is using
Inheritance to be able to override concrete Object methods, does that mean we should
probably only Mock interfaces? So that it won't force us to allow our services to be
overridden by Inheritance as it would make behaviour more unpredictable.

## Improvements

This is my first phase of refactor, thanks to the great suite of tests I'm quite confident
that everything is working as expected.

- I'm starting directly to use interface for the repository. First thing is that it'll
be possible to define concrete class as final so that no accidental/abusive inheritance
can be used but also interfaces can be mocked instead of concrete classes.
