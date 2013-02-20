Bitcoin_Dollar_Auction
======================

Dollar auction concept implemented with Bitcoin.

This project is based on the concept of the <a href="https://en.wikipedia.org/wiki/Dollar_auction">Dollar Auction</a>.

From Wikipedia:

"The dollar auction is a non-zero sum sequential game designed by economist Martin Shubik to illustrate a paradox brought about by traditional rational choice theory in which players with perfect information in the game are compelled to make an ultimately irrational decision based completely on a sequence of rational choices made throughout the game.

The setup involves an auctioneer who volunteers to auction-off a dollar bill with the following rule: the bill goes to the winner, however, all bidders must pay the highest amount they bid. The winner can get a dollar for mere five cents, but only if no-one else enters into the bidding war. The second-highest bidder is the biggest loser by paying the top amount he/she bid without getting anything back. The game begins with one of the players bidding 5 cents (the minimum), hoping to make a 95 cent profit. He can be outbid by another player bidding 10 cents, as a 90 cent profit is still desirable. Similarly, another bidder may bid 15 cents, making an 85 cent profit. Meanwhile, the first bidder may attempt to convert his loss of 5 cents into a gain of 80 cents by bidding 20 cents, and so on. Every player has a choice of either paying for nothing or bidding five cents more on the dollar. Any bid beyond the value of a dollar, is a loss for all bidders alike. Only the auctioneer gets to profit in the end."

****

In this version, the money does not go to the highest bid, but to the *last* one (the _last_ bid for a fixed length of blocks). There is a minimum bid, and since there is no incentive to bid more than the minimum, it is the _de facto_ bid.

Everything is parametrable in the file _global_variables.php_, for example:

$MIN_BET -> the minimum bid

$INCREASE_BLOCK -> the number of blocks the bet must wait to be considered the _last_ one. This value *only* applies to the folowing bids (since the GOAL_BLOCK is written in the database when the bid is found in the blockchain)
*WARNING*: This value _should_ be only decreased (increasing it will have no impact since the waiting time is not applied retroactively).

$BLOCKS_TO_NOTIFY -> Send a reminder email when the auction is about to end.

$BLOCKCHAIN_JSON -> URL to ask if the transaction took place. By default is calls blockchain.info


The MySQL database (must be created by hand) has only one table and its columns are:

address: Address that send the payment

block_found: block where the transaction was found

block_obj: block to REACH in order to (dependent on block_found AND the global variable INCREASE_BLOCK)


By default it calls blockchain.info to check if the transaction is in the blockchain, and the amount bidded is equal or greater than the $MIN_BET.

It features an email reminder when the auction is $BLOCKS_TO_NOTIFY blocks from the end. The email subject and body can be writte in the variables $EMAIL_SUBJECT and $MESSAGE_EMAIL, respectively.


*WARNING*: When setting the address to receive payments ($ADDRESS) do not forget to update the QR image (QRcode.png).
