<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given a user called :arg1
     */
    public function aUserCalled($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given :arg1
     */
    public function stepDefinition1($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given an email adress :arg1
     */
    public function anEmailAdress($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given belonging to the promotion :arg1
     */
    public function belongingToThePromotion($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given who wants to use the password :arg1
     */
    public function whoWantsToUseThePassword($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When he sends his :arg1
     */
    public function heSendsHis($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then he is registered in the database
     */
    public function heIsRegisteredInTheDatabase()
    {
        throw new PendingException();
    }

    /**
     * @Then an activation link is generated
     */
    public function anActivationLinkIsGenerated()
    {
        throw new PendingException();
    }

    /**
     * @Then an email is sent with the activation link
     */
    public function anEmailIsSentWithTheActivationLink()
    {
        throw new PendingException();
    }

    /**
     * @Given having passed the preselection tests
     */
    public function havingPassedThePreselectionTests()
    {
        throw new PendingException();
    }

    /**
     * @Given an :arg1 for a trusted domain
     */
    public function anForATrustedDomain($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I browse to the :arg1
     */
    public function iBrowseToThe($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then my email is set as verified
     */
    public function myEmailIsSetAsVerified()
    {
        throw new PendingException();
    }

    /**
     * @Then my account is set as verified
     */
    public function myAccountIsSetAsVerified()
    {
        throw new PendingException();
    }

    /**
     * @Given an :arg1 for a different email address
     */
    public function anForADifferentEmailAddress($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then my account stays un-verified
     */
    public function myAccountStaysUnVerified()
    {
        throw new PendingException();
    }

    /**
     * @Given he makes a typo in his email adress :arg1
     */
    public function heMakesATypoInHisEmailAdress($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given he wants a password :arg1
     */
    public function heWantsAPassword($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I send the :arg1
     */
    public function iSendThe($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the request is rejected
     */
    public function theRequestIsRejected()
    {
        throw new PendingException();
    }
}
