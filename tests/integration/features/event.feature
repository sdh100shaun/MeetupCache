Feature: event
  In order to get event information
  As a user
  I need to be able to fetch it from meetup

Scenario: fetch event from meetup
  Given I pass an id and url
  When I call the meetup api
  Then I should get an response
