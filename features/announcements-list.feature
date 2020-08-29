Feature: List of announcements
  Scenario: I want a list of announcements
    Given I am an unauthenticated user
    When I request a list of announcements from "http://localhost:8000"
    Then The results should include an announcement with ID "1"