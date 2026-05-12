# LingvaKit: Main project

## Quiz MS

### Question's answers structure:
#### Single choice
```json
{
  "questionUuid": "uuid-string",
  "type": "single_choice",
  "answerUuids": ["uuid-string"]
}
```

#### Multiple choice
```json
{
  "questionUuid": "uuid-string",
  "type": "single_choice",
  "answerUuids": [
    "uuid-string-1",
    "uuid-string-2"
  ]
}
```

#### Boolean
```json
{
  "questionUuid": "uuid-string",
  "type": "boolean",
  "boolean": true
}
```

#### Fill in blank
```json
{
  "questionUuid": "uuid-string",
  "type": "fill_in_blank",
  "blanks": [
    {"index": 0, "text": "Лондон"},
    {"index": 1, "text": "Темза"}
  ]
}
```

#### Match
```json
{
  "questionUuid": "uuid-string",
  "type": "match",
  "pairs": [
    {"left_id": "uuid-string-1", "right_id": "uuid-string-3"},
    {"left_id": "uuid-string-4", "right_id": "uuid-string-2"}
  ]
}
```

#### Build sentence
```json
{
  "questionUuid": "uuid-string",
  "type": "sentence_build",
  "sequence": [
    "uuid-string-1",
    "uuid-string-2",
    "uuid-string-3",
    "uuid-string-4"
  ]
}
```

#### Free text
```json
{
  "questionUuid": "uuid-string",
  "type": "free_text",
  "text": "Free text answer"
}
```