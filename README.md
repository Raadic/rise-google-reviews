# Rise Google Reviews

A WordPress plugin that allows you to display Google reviews on your website using shortcodes.

## Features

- Display Google reviews from your business listing
- Three display styles: Card Slider, Floating Badge, and Minimalist Cards
- Filter reviews by star rating
- Customizable appearance with light/dark themes
- Responsive design for all devices
- Cache system for improved performance

## Installation

1. Upload the `rise-google-reviews` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Google Reviews' in your admin menu to configure the plugin

## Configuration

1. **Get a Google Places API Key**
   - Go to the [Google Cloud Console](https://console.cloud.google.com/)
   - Create a new project or select an existing one
   - Enable the Places API
   - Create an API key
   - Copy the API key and paste it in the plugin settings

2. **Find Your Place ID**
   - Go to the [Place ID Finder](https://developers.google.com/maps/documentation/places/web-service/place-id)
   - Enter your business name and location
   - Select your business from the results
   - Copy the Place ID and paste it in the plugin settings

3. **Configure Cache Settings**
   - Set how long to cache the reviews before fetching new ones from Google (in hours)

## Usage

### Slider Shortcode

```
[rise_google_reviews_slider min_rating="4" max_reviews="10" slides_to_show="3" autoplay="true" theme="light"]
```

#### Parameters

- `min_rating` - Minimum star rating to display (1-5)
- `max_reviews` - Maximum number of reviews to display
- `slides_to_show` - Number of slides to show at once
- `slides_to_scroll` - Number of slides to scroll at once
- `autoplay` - Enable autoplay (true/false)
- `autoplay_speed` - Autoplay speed in milliseconds
- `arrows` - Show navigation arrows (true/false)
- `dots` - Show navigation dots (true/false)
- `theme` - Color theme (light/dark)

### Badge Shortcode

```
[rise_google_reviews_badge min_rating="4" max_reviews="5" position="bottom-right" theme="light" show_reviews="true"]
```

#### Parameters

- `min_rating` - Minimum star rating to display (1-5)
- `max_reviews` - Maximum number of reviews to display
- `position` - Badge position (top-left, top-right, bottom-left, bottom-right)
- `theme` - Color theme (light/dark)
- `show_reviews` - Show reviews in popup (true/false)

### Minimalist Cards Shortcode

```
[rise_google_reviews_cards min_rating="4" max_reviews="10" slides_to_show="3" theme="light" show_stars="true" show_date="true" card_style="rounded"]
```

#### Parameters

- `min_rating` - Minimum star rating to display (1-5)
- `max_reviews` - Maximum number of reviews to display
- `slides_to_show` - Number of slides to show at once
- `slides_to_scroll` - Number of slides to scroll at once
- `autoplay` - Enable autoplay (true/false)
- `autoplay_speed` - Autoplay speed in milliseconds
- `arrows` - Show navigation arrows (true/false)
- `dots` - Show navigation dots (true/false)
- `theme` - Color theme (light/dark)
- `show_stars` - Show rating stars (true/false)
- `show_date` - Show review date (true/false)
- `card_style` - Card style (rounded, square, minimal)

## Dependencies

This plugin uses the following third-party libraries:

- [Slick Carousel](https://kenwheeler.github.io/slick/) - For the review slider functionality

## License

This plugin is licensed under the GPL v2 or later.

## Credits

Developed by Rise
