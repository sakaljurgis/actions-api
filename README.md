## services for LibreChat agents actions or whatever the use case might be

This is a personal Laravel based app that provides a services api for [LibreChat](https://librechat.ai/) agents actions.

## Services/Usage

### Goolge Imagen image generation

based on [Vertex AI imagen API](https://cloud.google.com/vertex-ai/generative-ai/docs/model-reference/imagen-api)

`GET /generate-image?prompt=...&negative_prompt=...&sample_count=...&aspect_ratio=...`

or

`POST /generate-image` body

```json
{
    "prompt": "generate me an image",
    "sampleCount": 1,
    "negativePrompt": "optional",
    "aspectRatio": "1:1, 9:16, 16:9, 3:4, or 4:3. default 1:1"
}
```

Response

```json
{
  "generations": [
    {
      "url": "http://localhost:3000/storage/images/677e3c2eed7f2.png",
      "id": "677e3c2eed7f2"
    },
    {
      "url": "http://localhost:3000/storage/images/677e3c2eef716.png",
      "id": "677e3c2eef716"
    }
  ]
}
```

TODO - provide schema for librechat agents actions

TODO - add api key or smth

TODO - add delete images or expire

TODO - add upscale

## Setup/install

Generate laravel key, smth like `php artisan key:generate`

In Google cloud generate auth creds as in `auth.json.example.json`

Set the env variables from `env.example`
```bash
docker compose up
```

## License

No licence, do whatever you want. Laravel part is probably licenced.
