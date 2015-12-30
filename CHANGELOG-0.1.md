CHANGELOG for 0.1.x
===================

This changelog references the relevant changes (bug and security fixes) done
in 0.1 minor versions.

To get the diff for a specific change, go to https://github.com/antwebes/SocialRestBundle/commit/XXX where XXX is the change hash
To get the diff between two versions, go to https://github.com/antwebes/SocialRestBundle/compare/v0.1.0...v0.1.1

* 0.1.0 (2015-11-18)
 * This bundle worked up to 18-nov-2015, now include versions
 
* 0.1.1 (2015-11-18)
 * Include field id in Entity Visit, as primary key. Delete primary keys participant_id, participant_voyeur_id and visitDate. We need order visits by some field. And VisitDate only is date, it has not hour..
 
* 0.1.2 (2015-12-30)
 * Anonymous users can increment profile visit counter
 * Now this two call are equals:
 	* POST /api/users/{user_id}/visits ( Only increment count visits of profile)
 	* POST /api/users/{id}/profiles/visits ( If exist user session add visit, if not exist user session only increment count visits of profile
 * When adding a visit, if the user has a profile, we increment the visits counter in the profile
