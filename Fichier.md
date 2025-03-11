### Rapport

- npm run prod
- npm run dev
- ./vendor/bin/phpunit tests
- ./node_modules/.bin/mjml --watch mail.mjml
- ./bin/mailpit


Notification dans l'application :
    Un nouveau rapport a été soumis par [Nom du guichet]
    Le rapport soumis par [Nom du guichet] a été validé
    Le rapport soumis par [Nom du guichet] a été rejeté
    Un nouveau compte utilisateur a été créé

**Cron**
- Assurer que les guichets soumettent leurs rapports à temps. Si un guichet dépasse la date limite, il peut recevoir une alerte ou un message de rappel
- Permettre aux guichets de planifier la soumission de leurs rapports pour qu'ils soient envoyés automatiquement à une certaine date (ex : envoi automatique tous les mois)