---
date: 2026-10-31T20:29:00-04:00
---

Vote verification list
=====

An anonymized list of all votes cast in a region would be published on a government website, allowing visitors to tally the region's votes to verify official counts, and to verify their own votes were cast and counted as they expect them to be.  This will help individuals and, taken in aggregate, groups, have trust in the voting process.

The simplest solution would be to have a detachable tab on the bottom of the ballot with a unique, random number.  The ballot itself would have the same number.  The voter would take the tab after turning in their ballot.  When the list is later displayed, they can use the tab to look up their entry and verify their votes as they remember them.

To prevent others from attaching numbers to people, they shouldn't be sequential or connected at a given location, but randomly distributed through the full region.  The government shouldn't be able to associate numbers with people, but probably could either by watching or by planned number distribution.

To help with randomness, the "number" could be alphanumeric, or a cryptographic hash of the actual ballot number.  The hash would preferably be short enough to easily read and enter on the website but long enough to all but eliminate the chance of collision for any numbers of the possible lengths used on any ballot.

To possibly help a bit with government and others connecting a number with a person, the tab could have a pre-hashed number and the ballot could have the post-hashed number.  The government would only get the ballot with cryptographic hash of the number, and the list would show the hash with the votes.  The voter could enter the number into a form on the website to have it hash the number and look up their entry, or they could hash it themselves with the known hashing algorithm and then look up the hash in the list.  Having the physical tab with a number could help confirm a voter claiming their vote is wrong is the person who filled out that ballot, given the difficulty of computing the number from the hash.

To help more with this, and to prevent people who force a tab from a person to see their vote, eg controlling family, government officials, etc, the hash could be calculated and printed on the ballot when the person scans / submits it, a hash combining the number on the tab and a password the person creates and enters on the spot.  They would need to keep the tab and remember their password to find their record.  It would be harder for someone else to get their number AND force the password out of them.

If a voter sees a problem with their vote, they can of course voice it to their peers.  Ideally there would be some way to voice it to the government as well and either clear up the discrepancy before votes are ratified or have some sort of recourse.

With just a tab, any claims of misentered votes would require trust of the voter or their memory.  A carbon copy of paper ballots or small printout from the scanner / computer with the number or hash would help the voter verify their votes when submitting, and then help confirm their complaint later.

