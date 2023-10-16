<?php

class SearchController
{
    /**
     * Show search page
     *
     * @return void
     */
    public function searchPage() : void
    {
        include('view.php');
    }

    /**
     * Get all matching profiles based on name
     *
     * I feel I should have handled no data better, i.e. with 204/404 http code, but I'm skipping
     * that, and adding a comment instead.
     *
     * @return void
     */
    public function searchNames() : void
    {
        require_once('SearchModel.php');
        $searchModel = new SearchModel();
        $term = $_GET['term'];

        $data = $searchModel->getSearchData($term);

        // Set the content type, this helps JQuery parse the result
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($data);
    }

//Below is an example PHP function. Examine the code then fill in:
//1. The 9 missing comments in the function to explain the logic/what the code is doing
//2. The description at the top that explains what the function does
//3. Describe what each of the return values means

    /*
     * Return whether a profiles default email address is valid based on the userId passed.
     * This function checks if there is a default email address, and if not associates one.
     * Check if this email address has already been validated in the last year and if not do
     * further validation, checking if this is a valid email address as well as further checks.
     *
     * Return Values:
     *  -1 - Couldn't find an email address, either invalid userId or no email associated with profile
     *   0 - Email address could not be fully validated
     *   1 - Valid default email address
     *   2 - Invalid or blank email address associated with this userId
    */
    private function checkDefaultEmailValid($userId=null) {
        // Check a userId has actually been passed into the function
        if(empty($userId)) {
            return -1;
        }
        // Retrieve the default email address and it's validation status associated to a profile
        $defaultEmail = $this->getDefaultEmailByUserId($userId);
        // If we don't get data back we set a new default email and get the validation data for this new default
        if(empty($defaultEmail))
        {
            $this->set_default_email($userId);
            $defaultEmail =
                $this->getDefaultEmailByUserId($userId);
        }
        // If we still don't have data then this users email definitely isn't valid
        if(empty($defaultEmail))
        {
            return -1;
        }
        // If we have marked this email as valid in the last year lets assume it still is valid
        if($defaultEmail['valid']>=1 and
            ($defaultEmail['validated_on'] > (time() - strtotime('-12 months'))))
        {
            return 1;
        }
        // Extract the email address from the default email validity data for further checks
        $email = $defaultEmail['email'];
        // Check if email address is blank or an invalid email returning invalid if so
        if (empty($email) or !filter_var($email,
                FILTER_VALIDATE_EMAIL)) {
            return 2;
        }
        // Do more email validation [not really sure what could be here, maybe domain verification]
        $validationResults = $this->checkIfValid($email);
        // If email has failed any of our checks return failed (0), otherwise return success (1)
        if( ! $validationResults ) {
            return 0;
        } else {
            return 1;
        }
    }
}