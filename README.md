# Twitter Timeline

Part-1: User Timeline

    Start => User visits your script page.
    User will be asked to connect using his Twitter account using Twitter Auth.
    After authentication, your script will pull latest 10 tweets from his “home” timeline.
    10 tweets will be displayed using a jQuery-slideshow.

Part-2: Followers Timeline

    Below jQuery-slideshow, display list 10 followers (you can take any 10 random followers).
    When user will click on a follower name, 10 tweets from that follower’s user-timeline will be displayed in same jQuery-slider, without page refresh (use AJAX).

Part-3: Download Tweets

    There will be a download button to download all tweets for logged in user.
    Download can be performed in one of the following formats i.e. You choose the format you want. It would act as an advantage if you give the option to download the tweets in all the following formats:
    csv.
    For Google-spreadsheet export feature, your app-user must have Google account. Your app should ask for permission to create spreadsheet on user’s Google-Drive.
    Once user clicks download button (after choosing option) all tweets for logged in users should be downloaded.
