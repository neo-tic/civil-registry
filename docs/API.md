## Civil Registry API — Endpoint Reference

> All examples use fictitious data for demonstration only.

### Base URL

```
http://localhost:8000
```

### Lookup citizen

```
GET /api/v1/civil-register/{nni}?lang={fr|ar|both}
```

| Parameter | Type   | Required | Description |
|-----------|--------|----------|-------------|
| `nni`     | string | yes      | National Identification Number (10 digits) |
| `lang`    | string | no       | `fr`, `ar`, or `both` (defaults to `fr`) |

#### Request examples

```bash
# French payload (default)
curl --silent http://localhost:8000/api/v1/civil-register/1200000000

# Arabic payload
curl --silent "http://localhost:8000/api/v1/civil-register/1200000001?lang=ar"

# Both languages
curl --silent "http://localhost:8000/api/v1/civil-register/1200000002?lang=both"
```

#### Success (French)

```json
{
  "data": {
    "nni": "1200000000",
    "first_name": "Sidi",
    "last_name": "Ould Ahmed",
    "gender": "Masculin",
    "date_of_birth": "1990-04-01",
    "place_of_birth": "Nouakchott",
    "marital_status": "Marié(e)",
    "nationality": "Mauritanienne",
    "address": "Quartier Teyarett, Nouakchott, Mauritanie"
  },
  "meta": {
    "language": "fr",
    "retrieved_at": "2025-11-12T16:45:00+00:00",
    "source": "Civil Registry API Simulation – Not an official government service",
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage. Ce service n’est pas affilié au gouvernement mauritanien.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط. هذه الخدمة غير تابعة للحكومة الموريتانية."
    }
  }
}
```

#### Success (Arabic)

```json
{
  "data": {
    "nni": "1200000001",
    "first_name": "مريم",
    "last_name": "منت محمد",
    "gender": "أنثى",
    "date_of_birth": "1995-08-19",
    "place_of_birth": "نواذيبو",
    "marital_status": "متزوج/متزوجة",
    "nationality": "موريتانية",
    "address": "حي عرفات، نواذيبو، موريتانيا"
  },
  "meta": {
    "language": "ar",
    "retrieved_at": "2025-11-12T16:45:00+00:00",
    "source": "Civil Registry API Simulation – Not an official government service",
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط."
    }
  }
}
```

#### Success (Both languages)

```json
{
  "data": {
    "nni": "1200000002",
    "first_name": {
      "fr": "Ahmed",
      "ar": "أحمد"
    },
    "last_name": {
      "fr": "Ould Cheikh",
      "ar": "ولد الشيخ"
    },
    "gender": {
      "fr": "Masculin",
      "ar": "ذكر"
    },
    "date_of_birth": "1985-02-14",
    "place_of_birth": {
      "fr": "Kaédi",
      "ar": "كيدي"
    },
    "marital_status": {
      "fr": "Célibataire",
      "ar": "أعزب/عزباء"
    },
    "nationality": {
      "fr": "Mauritanienne",
      "ar": "موريتانية"
    },
    "address": {
      "fr": "Quartier Tevragh-Zeina, Kaédi, Mauritanie",
      "ar": "حي تفرغ زينة، كيدي، موريتانيا"
    }
  },
  "meta": {
    "language": "both",
    "retrieved_at": "2025-11-12T16:45:00+00:00",
    "source": "Civil Registry API Simulation – Not an official government service",
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط."
    }
  }
}
```

### Error model

Errors are JSON formatted with bilingual messages and structured metadata.

#### 400 — Invalid NNI format

```bash
curl --silent http://localhost:8000/api/v1/civil-register/ABC
```

```json
{
  "error": {
    "status": 400,
    "code": "INVALID_NNI_FORMAT",
    "message": {
      "fr": "Le format du Numéro National d’Identification (NNI) est invalide. Il doit contenir exactement 10 chiffres.",
      "ar": "تنسيق الرقم الوطني للتعريف غير صالح. يجب أن يتكون من 10 أرقام بالضبط."
    },
    "details": {
      "nni": "ABC"
    }
  },
  "meta": {
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط."
    },
    "timestamp": "2025-11-12T16:50:24+00:00"
  }
}
```

#### 400 — Unsupported language

```bash
curl --silent "http://localhost:8000/api/v1/civil-register/1200000000?lang=es"
```

```json
{
  "error": {
    "status": 400,
    "code": "UNSUPPORTED_LANGUAGE",
    "message": {
      "fr": "Le paramètre de langue fourni n’est pas pris en charge. Utilisez \"fr\", \"ar\" ou \"both\".",
      "ar": "معلمة اللغة المقدمة غير مدعومة. يرجى استخدام \"fr\" أو \"ar\" أو \"both\"."
    },
    "details": {
      "language": "es"
    }
  },
  "meta": {
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط."
    },
    "timestamp": "2025-11-12T16:50:24+00:00"
  }
}
```

#### 404 — Citizen not found

```bash
curl --silent http://localhost:8000/api/v1/civil-register/9999999999
```

```json
{
  "error": {
    "status": 404,
    "code": "CITIZEN_NOT_FOUND",
    "message": {
      "fr": "Aucun citoyen n’a été trouvé pour le NNI fourni.",
      "ar": "لم يتم العثور على أي مواطن للرقم الوطني المقدم."
    },
    "details": {
      "nni": "9999999999"
    }
  },
  "meta": {
    "disclaimer": {
      "fr": "Données fictives fournies uniquement à des fins de test et de prototypage.",
      "ar": "البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط."
    },
    "timestamp": "2025-11-12T16:50:24+00:00"
  }
}
```

### Notes

- All timestamps are emitted in ISO 8601 / RFC 3339 format (`DateTimeImmutable::ATOM`).
- For integration environments, consider rate limiting and authentication in a reverse proxy layer.
- Remember to surface the disclaimer when embedding data in downstream systems to avoid ambiguity about the dataset’s synthetic nature.

