# Bachelors Project Middle
## Implemented In Laravel Framework
## API calls:

### Authentication
```
auth/login

auth/register

auth/signup/activate/{token}

auth/send-confirmation-email

auth/reset-email
```

### Profile Management
```
profile/send-friend-request

profile/response-friend-request

profile/get-friends-list

profile/search-user

profile/change-first-name

profile/change-last-name

profile/change-password
```

### Individual game:
```
individual/check-answer/{questionId}/{currentAnswer}

individual/get-random-question/{numberOfQuestions?}

individual/finish-game/{numberOfCorrect}
```

### Group Chat
```
group/send-notification

group/get-chat-occupants

group/get-dialogs
```

### Tournament
```
tour/save-tour

tour/add-question-to-tour

tour/get-all-tours

tour/get-selected-tour/{tournamentId}

tour/save-tour-results

tour/get-tournament-results/{tournamentId}
```
