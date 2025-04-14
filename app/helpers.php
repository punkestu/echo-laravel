<?php

function array_to_params(array $params, array $except = [], array $change = []): string
{
    $query = [];
    foreach ($change as $key => $value) {
        $params[$key] = $value;
    }
    foreach ($params as $key => $value) {
        if (in_array($key, $except)) {
            continue;
        }
        if (is_array($value)) {
            foreach ($value as $v) {
                $query[] = "{$key}[]={$v}";
            }
        } else {
            $query[] = "{$key}={$value}";
        }
    }
    return implode('&', $query);
}

function array_to_inputhidden(array $params, array $except = [], array $change = []): string
{
    $query = [];
    foreach ($change as $key => $value) {
        $params[$key] = $value;
    }
    foreach ($params as $key => $value) {
        if (in_array($key, $except)) {
            continue;
        }
        if (is_array($value)) {
            foreach ($value as $v) {
                $query[] = "<input type='hidden' name='{$key}[]' value='{$v}'>";
            }
        } else {
            $query[] = "<input type='hidden' name='{$key}' value='{$value}'>";
        }
    }
    return implode('', $query);
}
