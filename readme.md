## Crunchbase Slack Integration

<img src="http://i.imgur.com/pRWQKyv.png">

This is a tool that allows for querying the crunchbase API via custom "slash" commands in a slack channel

## Commands

_`/cb-org facebook`_
 
Perform a search for a given company. Code will look for exact match first, and if nothing is found then fall back to CB's search endpoint


 
    Facebook - Facebook is an online social networking service that enables its users to connect with friends and family as well as make new connections
 
_`/cb-org faceb`_

A different response if an exact company name is not found

    Facebook
    https://www.crunchbase.com/organization/facebook
    
    FacebookLicious!
    https://www.crunchbase.com/organization/facebooklicious
    
    Facebookster
    https://www.crunchbase.com/organization/facebookster
    
    FaceBuzz
    https://www.crunchbase.com/organization/facebuzz
    
    Facebook Social Chatroulette
    https://www.crunchbase.com/organization/facebook-social-chat-roulette
     
_`/cb-per <persons name>`_ 

Return CB info on a given person
 
---

In the process of building out entities for each entity in the API for the purpose of IDE autocomplete

 * Address
 * Acquisition
 * Category
 * Degree
 * Fund
 * FundingRound
 * Image
 * Investment
 * Ipo
 * Job
 * Location
 * News
 * Organization
 * OrganizationSummary
 * Person
 * PersonSummary
 * Product
 * ProductSummary
 * Website
 * Video