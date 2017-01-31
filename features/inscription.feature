Feature: Basic register
  As a user
  In order to access the services
  I need to be able to register

  Rules:
    - Only people who went through the institute can access the platform (starting at preselection tests)
    - Specific domain that can be verified are automatically trusted and can access the application without further verifications
    - Specific email adresses can be entered in the database and also prevent human control to access the application
    - Other email adresses need a human control

  Scenario: Registering with a cs2i-lorient.fr domain
    Given a user called "Romain"
    And has a lastname "Becmeur"
    And an email adress "r.becmeur@cs2i-lorient.fr"
    And belonging to the promotion 10
    And who wants to use the password "strong password"
    When he sends his registering information
    Then he is registered in the database
    And an activation link is generated
    And an email is sent with the activation link

  Scenario: Registering with a different email adress
    Given a user called "Antoine"
    And has a lastname "Le Guen"
    And an email adress "a.leguen@gmail.com"
    And belonging to the promotion 10
    And who wants to use the password "anotherStrongPassword"
    When he sends his "registering information"
    Then he is registered in the database
    And an activation link is generated
    And an email is sent with the activation link

  Scenario: Registering with an email adress that has already been set as trusted
    Given a user called "Yohann"
    And and has a lastname "Cabelguen"
    And a registered email adress "y.cabelguen@gmail.com" in the database
    And an email adress "y.cabelguen@gmail.com"
    And having passed the preselection tests
    And who wants to use the password "strongPasswordToo"
    When he sends his "registering information"
    Then he is registered in the database
    And an activation link is generated
    And an email is sent with the activation link

  Scenario: Verifying a trusted email adress
    Given an "activation link" for a trusted domain
    When I browse to the "activation link"
    Then my email is set as verified
    And my account is set as verified

  Scenario: Verifying an untrusted email adress
    Given an "activation link" for a different email address
    When I browse to the "activation link"
    Then my email is set as verified
    And my account stays un-verified

  Scenario: Registering with wrong informations
    Given a user called "Alain"
    And has a lastname "Inisan"
    And he makes a typo in his email adress "a.inisan.fr"
    And he wants a password "notSoStrongPassword"
    When I send the "registering information"
    Then the request is rejected
