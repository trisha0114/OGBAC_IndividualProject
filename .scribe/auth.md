# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {YOUR_JWT_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

To authenticate, log in using the PoolDesk login endpoint and copy the JWT token from the response. Use this token as a Bearer token in the Authorization header.
